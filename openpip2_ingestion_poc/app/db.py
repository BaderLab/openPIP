from __future__ import annotations

import hashlib
import json
import uuid
from collections.abc import AsyncIterator
from typing import Optional

import asyncpg

from .models import CanonicalInteraction

DDL = """
CREATE TABLE IF NOT EXISTS datasets (
    id BIGSERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT,
    source_file TEXT,
    interaction_count BIGINT NOT NULL DEFAULT 0,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE IF NOT EXISTS proteins (
    id BIGSERIAL PRIMARY KEY,
    primary_id TEXT NOT NULL UNIQUE,
    gene_name TEXT,
    protein_name TEXT
);

CREATE TABLE IF NOT EXISTS interactions (
    id BIGSERIAL PRIMARY KEY,
    dataset_id BIGINT NOT NULL,
    pair_key TEXT NOT NULL,
    interaction_hash TEXT NOT NULL,
    score TEXT,
    removed TEXT DEFAULT '0',
    binding_start TEXT,
    binding_end TEXT,
    interactor_a_ns TEXT NOT NULL,
    interactor_a_id TEXT NOT NULL,
    interactor_b_ns TEXT NOT NULL,
    interactor_b_id TEXT NOT NULL,
    interaction_type TEXT,
    confidence_score DOUBLE PRECISION,
    publication_id TEXT,
    source_file TEXT NOT NULL,
    source_row BIGINT NOT NULL,
    parser_version TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    FOREIGN KEY (dataset_id) REFERENCES datasets(id) ON DELETE CASCADE,
    UNIQUE (interaction_hash)
);

CREATE INDEX IF NOT EXISTS idx_interactions_pair_key ON interactions(pair_key);
CREATE INDEX IF NOT EXISTS idx_interactions_dataset ON interactions(dataset_id);

CREATE TABLE IF NOT EXISTS annotations (
    id BIGSERIAL PRIMARY KEY,
    interaction_id BIGINT NOT NULL REFERENCES interactions(id) ON DELETE CASCADE,
    key TEXT NOT NULL,
    value TEXT NOT NULL
);

CREATE OR REPLACE VIEW dataset AS
SELECT id, name, description, source_file AS file_path
FROM datasets;

CREATE OR REPLACE VIEW protein AS
SELECT id, primary_id AS uniprot_id, gene_name, protein_name
FROM proteins;

CREATE OR REPLACE VIEW interaction AS
SELECT id, score, removed, binding_start, binding_end
FROM interactions;

CREATE OR REPLACE VIEW annotation AS
SELECT id, key AS name, value AS description
FROM annotations;

CREATE TABLE IF NOT EXISTS upload_files (
    id UUID PRIMARY KEY,
    dataset_id BIGINT NOT NULL,
    filename TEXT NOT NULL,
    storage_key TEXT NOT NULL,
    parser_hint TEXT NOT NULL,
    uploaded_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    FOREIGN KEY (dataset_id) REFERENCES datasets(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS upload_jobs (
    id UUID PRIMARY KEY,
    upload_file_id UUID NOT NULL REFERENCES upload_files(id) ON DELETE CASCADE,
    dataset_id BIGINT NOT NULL,
    storage_key TEXT NOT NULL,
    parser_hint TEXT,
    stage TEXT NOT NULL CHECK (stage IN ('queued','parsing','validating','writing','completed','failed')),
    status TEXT NOT NULL DEFAULT 'parsing' CHECK (status IN ('parsing', 'validated', 'committed')),
    total_rows BIGINT,
    processed_rows BIGINT NOT NULL DEFAULT 0,
    inserted_rows BIGINT NOT NULL DEFAULT 0,
    skipped_rows BIGINT NOT NULL DEFAULT 0,
    failed_rows BIGINT NOT NULL DEFAULT 0,
    error_summary TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE IF NOT EXISTS upload_job_errors (
    id BIGSERIAL PRIMARY KEY,
    job_id UUID NOT NULL REFERENCES upload_jobs(id) ON DELETE CASCADE,
    source_row BIGINT NOT NULL,
    error_code TEXT NOT NULL,
    error_message TEXT NOT NULL,
    remediation_hint TEXT,
    raw_payload JSONB,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);
"""


def interaction_hash(dataset_id: int, a_ns: str, a_id: str, b_ns: str, b_id: str) -> str:
    left = f"{a_ns}:{a_id}".lower()
    right = f"{b_ns}:{b_id}".lower()
    pair = "::".join(sorted([left, right]))
    return hashlib.sha256(f"{dataset_id}|{pair}".encode("utf-8")).hexdigest()


async def create_db_pool(database_url: str) -> asyncpg.Pool:
    return await asyncpg.create_pool(dsn=database_url, min_size=1, max_size=10)


async def init_db(pool: asyncpg.Pool) -> None:
    async with pool.acquire() as conn:
        await conn.execute(DDL)


async def ensure_dataset(pool: asyncpg.Pool, dataset_id: int) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            INSERT INTO datasets (id, name)
            VALUES ($1, $2)
            ON CONFLICT (id) DO NOTHING
            """,
            dataset_id,
            f"Dataset {dataset_id}",
        )


async def create_upload_file(
    pool: asyncpg.Pool,
    dataset_id: int,
    filename: str,
    storage_key: str,
    parser_hint: str,
) -> str:
    file_id = str(uuid.uuid4())
    async with pool.acquire() as conn:
        await conn.execute(
            """
            INSERT INTO upload_files (id, dataset_id, filename, storage_key, parser_hint)
            VALUES ($1::uuid, $2, $3, $4, $5)
            """,
            file_id,
            dataset_id,
            filename,
            storage_key,
            parser_hint,
        )
    return file_id


async def create_job(
    pool: asyncpg.Pool,
    upload_file_id: str,
    dataset_id: int,
    storage_key: str,
    parser_hint: Optional[str],
) -> str:
    job_id = str(uuid.uuid4())
    async with pool.acquire() as conn:
        await conn.execute(
            """
            INSERT INTO upload_jobs (id, upload_file_id, dataset_id, storage_key, parser_hint, stage)
            VALUES ($1::uuid, $2::uuid, $3, $4, $5, 'queued')
            """,
            job_id,
            upload_file_id,
            dataset_id,
            storage_key,
            parser_hint,
        )
    return job_id


async def get_job(pool: asyncpg.Pool, job_id: str) -> Optional[dict]:
    async with pool.acquire() as conn:
        try:
            row = await conn.fetchrow(
                """
                SELECT id::text, upload_file_id::text, dataset_id, storage_key, parser_hint,
                       stage, status, total_rows, processed_rows, inserted_rows, skipped_rows,
                       failed_rows, error_summary, created_at, updated_at
                FROM upload_jobs
                WHERE id = $1::uuid
                """,
                job_id,
            )
        except asyncpg.DataError:
            return None
    return dict(row) if row else None


async def list_jobs_for_dataset(pool: asyncpg.Pool, dataset_id: int) -> list[dict]:
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT id::text, dataset_id, stage, status, processed_rows, inserted_rows,
                   skipped_rows, failed_rows, created_at, updated_at
            FROM upload_jobs
            WHERE dataset_id = $1
            ORDER BY created_at DESC
            """,
            dataset_id,
        )
    return [dict(r) for r in rows]


async def list_job_errors(pool: asyncpg.Pool, job_id: str, limit: int, offset: int) -> list[dict]:
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT id, source_row, error_code, error_message, remediation_hint, raw_payload, created_at
            FROM upload_job_errors
            WHERE job_id = $1::uuid
            ORDER BY id ASC
            LIMIT $2 OFFSET $3
            """,
            job_id,
            limit,
            offset,
        )
    return [dict(r) for r in rows]


async def set_job_stage(pool: asyncpg.Pool, job_id: str, stage: str) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            UPDATE upload_jobs
            SET stage = $2, updated_at = now()
            WHERE id = $1::uuid
            """,
            job_id,
            stage,
        )


async def set_job_status(pool: asyncpg.Pool, job_id: str, status: str) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            UPDATE upload_jobs
            SET status = $2, updated_at = now()
            WHERE id = $1::uuid
            """,
            job_id,
            status,
        )


async def set_job_progress(pool: asyncpg.Pool, job_id: str, processed_rows: int) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            UPDATE upload_jobs
            SET processed_rows = $2, updated_at = now()
            WHERE id = $1::uuid
            """,
            job_id,
            processed_rows,
        )


def remediation_for_code(code: str) -> str:
    hints = {
        "BAD_IDENTIFIER": "Use namespace:value, for example uniprotkb:P12345",
        "SHORT_ROW": "Provide all required columns for selected parser",
        "MISSING_METHOD": "Populate interaction detection method column",
        "CSV_SHORT_COLS": "CSV rows need at least interactor_a, interactor_b",
        "ROW_RUNTIME": "Check row encoding and delimiters",
    }
    return hints.get(code, "Inspect row payload and parser-specific required fields")


async def add_job_error(
    pool: asyncpg.Pool,
    job_id: str,
    source_row: int,
    error_code: str,
    error_message: str,
    raw_payload: Optional[str],
) -> None:
    payload = json.dumps({"line": raw_payload}) if raw_payload else None
    async with pool.acquire() as conn:
        await conn.execute(
            """
            INSERT INTO upload_job_errors (
                job_id, source_row, error_code, error_message, remediation_hint, raw_payload
            )
            VALUES ($1::uuid, $2, $3, $4, $5, $6::jsonb)
            """,
            job_id,
            source_row,
            error_code,
            error_message,
            remediation_for_code(error_code),
            payload,
        )


async def bulk_insert_interactions(
    pool: asyncpg.Pool,
    rows: list[CanonicalInteraction],
) -> tuple[int, int]:
    if not rows:
        return 0, 0

    inserted = 0
    async with pool.acquire() as conn:
        for row in rows:
            row_hash = interaction_hash(
                row.dataset_id,
                row.interactor_a_ns,
                row.interactor_a_id,
                row.interactor_b_ns,
                row.interactor_b_id,
            )
            result = await conn.fetchval(
                """
                INSERT INTO interactions (
                    dataset_id, pair_key, interaction_hash, score, removed, binding_start, binding_end,
                    interactor_a_ns, interactor_a_id,
                    interactor_b_ns, interactor_b_id, interaction_type, confidence_score,
                    publication_id, source_file, source_row, parser_version
                )
                VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17)
                ON CONFLICT (interaction_hash) DO NOTHING
                RETURNING id
                """,
                row.dataset_id,
                row.pair_key,
                row_hash,
                str(row.confidence_score) if row.confidence_score is not None else None,
                "0",
                None,
                None,
                row.interactor_a_ns,
                row.interactor_a_id,
                row.interactor_b_ns,
                row.interactor_b_id,
                row.interaction_type,
                row.confidence_score,
                row.publication_id,
                row.source_file,
                row.source_row,
                row.parser_version,
            )
            if result is not None:
                inserted += 1

    skipped = len(rows) - inserted
    return inserted, skipped


async def complete_job(
    pool: asyncpg.Pool,
    job_id: str,
    inserted_rows: int,
    skipped_rows: int,
    failed_rows: int,
) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            UPDATE upload_jobs
            SET stage = 'completed', inserted_rows = $2, skipped_rows = $3,
                failed_rows = $4, updated_at = now()
            WHERE id = $1::uuid
            """,
            job_id,
            inserted_rows,
            skipped_rows,
            failed_rows,
        )


async def fail_job(
    pool: asyncpg.Pool,
    job_id: str,
    reason: str,
    inserted_rows: int,
    failed_rows: int,
) -> None:
    async with pool.acquire() as conn:
        await conn.execute(
            """
            UPDATE upload_jobs
            SET stage = 'failed', inserted_rows = $2, failed_rows = $3,
                error_summary = $4, updated_at = now()
            WHERE id = $1::uuid
            """,
            job_id,
            inserted_rows,
            failed_rows,
            reason,
        )


async def get_job_errors_as_csv(pool: asyncpg.Pool, job_id: str) -> AsyncIterator[str]:
    yield "source_row,error_code,error_message,remediation_hint,raw_payload\n"
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT source_row, error_code, error_message, remediation_hint, raw_payload
            FROM upload_job_errors
            WHERE job_id = $1::uuid
            ORDER BY id ASC
            """,
            job_id,
        )

    def esc(val: Optional[object]) -> str:
        if val is None:
            return ""
        text = str(val)
        if "," in text or '"' in text or "\n" in text:
            return '"' + text.replace('"', '""') + '"'
        return text

    for source_row, error_code, error_message, remediation_hint, raw_payload in rows:
        yield (
            f"{esc(source_row)},{esc(error_code)},{esc(error_message)},"
            f"{esc(remediation_hint)},{esc(raw_payload)}\n"
        )


async def export_interactions_csv(pool: asyncpg.Pool, dataset_id: int) -> AsyncIterator[str]:
    yield "dataset_id,interactor_a,interactor_b,interaction_type,confidence_score,publication_id\n"
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT dataset_id, interactor_a_ns, interactor_a_id, interactor_b_ns, interactor_b_id,
                   interaction_type, confidence_score, publication_id
            FROM interactions
            WHERE dataset_id = $1
            ORDER BY id ASC
            """,
            dataset_id,
        )
    for r in rows:
        a = f"{r['interactor_a_ns']}:{r['interactor_a_id']}"
        b = f"{r['interactor_b_ns']}:{r['interactor_b_id']}"
        yield f"{r['dataset_id']},{a},{b},{r['interaction_type'] or ''},{r['confidence_score'] or ''},{r['publication_id'] or ''}\n"


async def export_interactions_mitab(pool: asyncpg.Pool, dataset_id: int) -> AsyncIterator[str]:
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT interactor_a_ns, interactor_a_id, interactor_b_ns, interactor_b_id,
                   interaction_type, publication_id, confidence_score
            FROM interactions
            WHERE dataset_id = $1
            ORDER BY id ASC
            """,
            dataset_id,
        )
    for r in rows:
        conf = f"intact-miscore:{r['confidence_score']}" if r["confidence_score"] is not None else "-"
        yield (
            f"{r['interactor_a_ns']}:{r['interactor_a_id']}\t"
            f"{r['interactor_b_ns']}:{r['interactor_b_id']}\t-\t-\t-\t-\t"
            f"psi-mi:MI:0000(unspecified method)\t-\t{r['publication_id'] or '-'}\t"
            f"taxid:-\ttaxid:-\t{r['interaction_type'] or '-'}\t-\t-\t{conf}\n"
        )


async def search_interactions(
    pool: asyncpg.Pool,
    query: str,
    dataset_id: Optional[int],
    limit: int,
    offset: int,
) -> list[dict]:
    like = f"%{query.lower()}%"
    async with pool.acquire() as conn:
        if dataset_id is None:
            rows = await conn.fetch(
                """
                SELECT id, dataset_id, interactor_a_ns, interactor_a_id, interactor_b_ns,
                       interactor_b_id, interaction_type, confidence_score, publication_id
                FROM interactions
                WHERE lower(interactor_a_id) LIKE $1
                   OR lower(interactor_b_id) LIKE $1
                   OR lower(coalesce(publication_id, '')) LIKE $1
                ORDER BY id DESC
                LIMIT $2 OFFSET $3
                """,
                like,
                limit,
                offset,
            )
        else:
            rows = await conn.fetch(
                """
                SELECT id, dataset_id, interactor_a_ns, interactor_a_id, interactor_b_ns,
                       interactor_b_id, interaction_type, confidence_score, publication_id
                FROM interactions
                WHERE dataset_id = $1
                  AND (
                    lower(interactor_a_id) LIKE $2
                    OR lower(interactor_b_id) LIKE $2
                    OR lower(coalesce(publication_id, '')) LIKE $2
                  )
                ORDER BY id DESC
                LIMIT $3 OFFSET $4
                """,
                dataset_id,
                like,
                limit,
                offset,
            )
    return [dict(r) for r in rows]


async def list_datasets(pool: asyncpg.Pool) -> list[dict]:
    async with pool.acquire() as conn:
        rows = await conn.fetch(
            """
            SELECT d.id, d.name, d.description, d.source_file,
                   COUNT(i.id)::bigint AS interaction_count
            FROM datasets d
            LEFT JOIN interactions i ON i.dataset_id = d.id
            GROUP BY d.id
            ORDER BY d.id ASC
            """
        )
    return [dict(r) for r in rows]
