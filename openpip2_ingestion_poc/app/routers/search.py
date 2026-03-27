from __future__ import annotations

from typing import Optional

from fastapi import APIRouter, Query, Request

from ..schemas.api import SearchResponse
from ..services.search_service import search

router = APIRouter(prefix="/search", tags=["search"])


@router.get("", response_model=SearchResponse)
async def search_interactions(
    request: Request,
    q: str = Query(default=""),
    dataset_id: Optional[int] = Query(default=None),
    limit: int = Query(default=100),
    offset: int = Query(default=0),
):
    return await search(
        db_pool=request.app.state.db_pool,
        query=q,
        dataset_id=dataset_id,
        limit=limit,
        offset=offset,
    )
