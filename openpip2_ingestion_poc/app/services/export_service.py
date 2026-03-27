from collections.abc import AsyncIterator

from ..db import export_interactions_csv, export_interactions_mitab


async def stream_csv(*, db_pool, dataset_id: int) -> AsyncIterator[str]:
    async for line in export_interactions_csv(db_pool, dataset_id):
        yield line


async def stream_mitab(*, db_pool, dataset_id: int) -> AsyncIterator[str]:
    async for line in export_interactions_mitab(db_pool, dataset_id):
        yield line
