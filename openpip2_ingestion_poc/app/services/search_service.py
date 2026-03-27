from __future__ import annotations

from typing import Optional

from ..db import search_interactions


async def search(*, db_pool, query: str, dataset_id: Optional[int], limit: int, offset: int) -> dict:
    rows = await search_interactions(
        pool=db_pool,
        query=query,
        dataset_id=dataset_id,
        limit=max(1, min(limit, 500)),
        offset=max(0, offset),
    )
    return {"items": rows, "count": len(rows)}
