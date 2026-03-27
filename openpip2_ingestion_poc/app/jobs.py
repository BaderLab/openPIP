from pathlib import Path

from .db import (
    add_job_error,
    bulk_insert_interactions,
    complete_job,
    fail_job,
    set_job_progress,
    set_job_stage,
    set_job_status,
)
from .models import CanonicalInteraction, RowValidationError
from .parsers import parse_line


async def validate_upload_job(
    ctx,
    job_id: str,
    dataset_id: int,
    storage_key: str,
    parser_hint: str = "psi_mitab",
) -> dict:
    """Phase 1: validate file and persist row-level errors, no interaction writes."""
    db_pool = ctx["db_pool"]
    storage_root = Path(ctx["storage_root"])
    file_path = storage_root / storage_key
    processed = 0
    failed = 0

    await set_job_stage(db_pool, job_id, "parsing")
    await set_job_status(db_pool, job_id, "parsing")

    try:
        with file_path.open("r", encoding="utf-8", errors="replace") as f:
            for row_no, line in enumerate(f, start=1):
                if not line.strip() or line.startswith("#"):
                    continue
                if parser_hint == "csv" and row_no == 1:
                    continue

                try:
                    _ = parse_line(
                        parser_hint=parser_hint,
                        row_no=row_no,
                        line=line,
                        dataset_id=dataset_id,
                        source_file=storage_key,
                    )
                except RowValidationError as err:
                    failed += 1
                    await add_job_error(
                        db_pool,
                        job_id=job_id,
                        source_row=row_no,
                        error_code=err.code,
                        error_message=err.message,
                        raw_payload=line.rstrip("\n"),
                    )
                except Exception as exc:
                    failed += 1
                    await add_job_error(
                        db_pool,
                        job_id=job_id,
                        source_row=row_no,
                        error_code="ROW_RUNTIME",
                        error_message=str(exc),
                        raw_payload=line.rstrip("\n"),
                    )

                processed = row_no
                await set_job_progress(db_pool, job_id, processed)

        await set_job_stage(db_pool, job_id, "validating")
        await set_job_status(db_pool, job_id, "validated")
        await set_job_stage(db_pool, job_id, "completed")

        return {
            "job_id": job_id,
            "processed": processed,
            "validation_errors": failed,
            "status": "validated",
        }
    except Exception as exc:
        await fail_job(
            db_pool,
            job_id=job_id,
            reason=f"Fatal validation error: {exc}",
            inserted_rows=0,
            failed_rows=failed,
        )
        raise


async def commit_upload_job(
    ctx,
    job_id: str,
    dataset_id: int,
    storage_key: str,
    parser_hint: str = "psi_mitab",
) -> dict:
    """Phase 2: write validated interactions and count duplicates as skipped."""
    db_pool = ctx["db_pool"]
    storage_root = Path(ctx["storage_root"])
    file_path = storage_root / storage_key
    inserted = 0
    skipped = 0
    failed = 0
    batch: list[CanonicalInteraction] = []

    await set_job_stage(db_pool, job_id, "writing")

    try:
        with file_path.open("r", encoding="utf-8", errors="replace") as f:
            for row_no, line in enumerate(f, start=1):
                if not line.strip() or line.startswith("#"):
                    continue
                if parser_hint == "csv" and row_no == 1:
                    continue

                try:
                    interaction = parse_line(
                        parser_hint=parser_hint,
                        row_no=row_no,
                        line=line,
                        dataset_id=dataset_id,
                        source_file=storage_key,
                    )
                    batch.append(interaction)

                    if len(batch) >= 1000:
                        b_ins, b_skip = await bulk_insert_interactions(db_pool, batch)
                        inserted += b_ins
                        skipped += b_skip
                        batch.clear()
                except RowValidationError:
                    failed += 1
                except Exception as exc:
                    failed += 1

        if batch:
            b_ins, b_skip = await bulk_insert_interactions(db_pool, batch)
            inserted += b_ins
            skipped += b_skip

        await set_job_status(db_pool, job_id, "committed")
        await complete_job(
            db_pool,
            job_id=job_id,
            inserted_rows=inserted,
            skipped_rows=skipped,
            failed_rows=failed,
        )

        return {
            "job_id": job_id,
            "inserted": inserted,
            "skipped_duplicates": skipped,
            "validation_failures": failed,
            "status": "committed",
        }
    except Exception as exc:
        await fail_job(
            db_pool,
            job_id=job_id,
            reason=f"Fatal commit error: {exc}",
            inserted_rows=inserted,
            failed_rows=failed,
        )
        raise
