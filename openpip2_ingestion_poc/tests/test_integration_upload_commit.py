from pathlib import Path

import pytest

from app.db import create_db_pool, get_job, init_db
from app.jobs import commit_upload_job, validate_upload_job


@pytest.mark.asyncio
async def test_full_validate_then_commit_flow(tmp_path: Path):
    database_url = "postgresql://openpip:openpip@localhost:5433/openpip_poc"

    try:
        pool = await create_db_pool(database_url)
    except Exception:
        pytest.skip("Postgres not available for integration test")

    try:
        await init_db(pool)

        storage_root = tmp_path / "uploads"
        storage_root.mkdir(parents=True, exist_ok=True)

        src = Path("sample_data/mitab_demo.tsv")
        if not src.exists():
            src = Path(__file__).resolve().parents[1] / "sample_data" / "mitab_demo.tsv"

        storage_key = "incoming/test.tsv"
        target = storage_root / storage_key
        target.parent.mkdir(parents=True, exist_ok=True)
        target.write_text(src.read_text(encoding="utf-8"), encoding="utf-8")

        # Minimal fixtures for direct job invocation
        async with pool.acquire() as conn:
            await conn.execute("INSERT INTO datasets (id, name) VALUES (42, 'Dataset 42') ON CONFLICT (id) DO NOTHING")
            await conn.execute(
                """
                INSERT INTO upload_files (id, dataset_id, filename, storage_key, parser_hint)
                VALUES ('11111111-1111-1111-1111-111111111111', 42, 'test.tsv', $1, 'psi_mitab')
                ON CONFLICT (id) DO NOTHING
                """,
                storage_key,
            )
            await conn.execute(
                """
                INSERT INTO upload_jobs (
                    id, upload_file_id, dataset_id, storage_key, parser_hint, stage, status
                )
                VALUES (
                    '22222222-2222-2222-2222-222222222222',
                    '11111111-1111-1111-1111-111111111111',
                    42,
                    $1,
                    'psi_mitab',
                    'queued',
                    'parsing'
                )
                ON CONFLICT (id) DO NOTHING
                """,
                storage_key,
            )

        ctx = {"db_pool": pool, "storage_root": str(storage_root)}

        validated = await validate_upload_job(
            ctx,
            "22222222-2222-2222-2222-222222222222",
            42,
            storage_key,
            "psi_mitab",
        )
        assert validated["status"] == "validated"

        committed = await commit_upload_job(
            ctx,
            "22222222-2222-2222-2222-222222222222",
            42,
            storage_key,
            "psi_mitab",
        )
        assert committed["status"] == "committed"

        job = await get_job(pool, "22222222-2222-2222-2222-222222222222")
        assert job is not None
        assert job["stage"] == "completed"
        assert job["status"] == "committed"
    finally:
        await pool.close()
