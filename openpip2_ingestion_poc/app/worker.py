from .config import get_database_url, get_redis_settings, get_storage_root
from .db import create_db_pool, init_db

from .jobs import validate_upload_job, commit_upload_job

async def startup(ctx):
    db_pool = await create_db_pool(get_database_url())
    await init_db(db_pool)
    ctx["db_pool"] = db_pool
    ctx["storage_root"] = get_storage_root()


async def shutdown(ctx):
    await ctx["db_pool"].close()


class WorkerSettings:
    functions = [validate_upload_job, commit_upload_job]
    redis_settings = get_redis_settings()
    on_startup = startup
    on_shutdown = shutdown
    max_jobs = 8
    job_timeout = 60 * 60
    keep_result = 3600
