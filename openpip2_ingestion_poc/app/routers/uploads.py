import asyncio
import json

from fastapi import APIRouter, File, Form, Request, UploadFile
from fastapi.responses import StreamingResponse

from ..db import get_job_errors_as_csv
from ..schemas.api import CommitResponse, JobCreateResponse, JobErrorListResponse, JobStatusResponse
from ..services.upload_service import (
    create_upload_and_enqueue_validation,
    enqueue_commit,
    get_job_errors,
    get_job_or_404,
)

router = APIRouter(prefix="/uploads", tags=["uploads"])


@router.post("/jobs", response_model=JobCreateResponse)
async def create_upload_job(
    request: Request,
    file: UploadFile = File(...),
    dataset_id: int = Form(...),
    parser_hint: str = Form(default="psi_mitab"),
):
    return await create_upload_and_enqueue_validation(
        db_pool=request.app.state.db_pool,
        redis=request.app.state.redis,
        storage_root=request.app.state.storage_root,
        file=file,
        dataset_id=dataset_id,
        parser_hint=parser_hint,
    )


@router.get("/jobs/{job_id}", response_model=JobStatusResponse)
async def get_upload_job(request: Request, job_id: str):
    return await get_job_or_404(db_pool=request.app.state.db_pool, job_id=job_id)


@router.post("/jobs/{job_id}/commit", response_model=CommitResponse)
async def commit_upload_job(request: Request, job_id: str):
    return await enqueue_commit(db_pool=request.app.state.db_pool, redis=request.app.state.redis, job_id=job_id)


@router.get("/jobs/{job_id}/errors", response_model=JobErrorListResponse)
async def get_upload_job_errors(request: Request, job_id: str, limit: int = 100, offset: int = 0):
    return await get_job_errors(
        db_pool=request.app.state.db_pool,
        job_id=job_id,
        limit=limit,
        offset=offset,
    )


@router.get("/jobs/{job_id}/errors/export")
async def export_upload_job_errors(request: Request, job_id: str):
    _ = await get_job_or_404(db_pool=request.app.state.db_pool, job_id=job_id)
    return StreamingResponse(
        get_job_errors_as_csv(request.app.state.db_pool, job_id),
        media_type="text/csv",
        headers={"Content-Disposition": f"attachment; filename=errors_{job_id}.csv"},
    )


@router.get("/jobs/{job_id}/events")
async def stream_upload_job_events(request: Request, job_id: str, interval: float = 1.0):
    _ = await get_job_or_404(db_pool=request.app.state.db_pool, job_id=job_id)

    poll_interval = max(0.2, min(interval, 5.0))

    async def event_stream():
        last_payload = None
        while True:
            current = await get_job_or_404(db_pool=request.app.state.db_pool, job_id=job_id)
            payload = json.dumps(current, default=str)

            if payload != last_payload:
                yield f"event: progress\\ndata: {payload}\\n\\n"
                last_payload = payload

            if current.get("stage") in {"completed", "failed"}:
                yield "event: done\\ndata: {}\\n\\n"
                break

            await asyncio.sleep(poll_interval)

    return StreamingResponse(
        event_stream(),
        media_type="text/event-stream",
        headers={
            "Cache-Control": "no-cache",
            "Connection": "keep-alive",
            "X-Accel-Buffering": "no",
        },
    )
