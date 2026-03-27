from ..db import list_datasets


async def get_datasets(*, db_pool) -> dict:
    rows = await list_datasets(pool=db_pool)
    return {"items": rows, "count": len(rows)}
