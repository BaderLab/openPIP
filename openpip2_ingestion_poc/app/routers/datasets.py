from fastapi import APIRouter, Request

from ..schemas.api import DatasetListResponse
from ..services.dataset_service import get_datasets

router = APIRouter(prefix="/datasets", tags=["datasets"])


@router.get("", response_model=DatasetListResponse)
async def list_dataset_stats(request: Request):
    return await get_datasets(db_pool=request.app.state.db_pool)
