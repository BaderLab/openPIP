from fastapi import APIRouter, Request
from fastapi.responses import StreamingResponse

from ..services.export_service import stream_csv, stream_mitab

router = APIRouter(prefix="/exports", tags=["exports"])


@router.get("/datasets/{dataset_id}/csv")
async def export_dataset_csv(request: Request, dataset_id: int):
    async def gen():
        async for line in stream_csv(db_pool=request.app.state.db_pool, dataset_id=dataset_id):
            yield line

    return StreamingResponse(
        gen(),
        media_type="text/csv",
        headers={"Content-Disposition": f"attachment; filename=dataset_{dataset_id}.csv"},
    )


@router.get("/datasets/{dataset_id}/mitab")
async def export_dataset_mitab(request: Request, dataset_id: int):
    async def gen():
        async for line in stream_mitab(db_pool=request.app.state.db_pool, dataset_id=dataset_id):
            yield line

    return StreamingResponse(
        gen(),
        media_type="text/plain",
        headers={"Content-Disposition": f"attachment; filename=dataset_{dataset_id}.mitab"},
    )
