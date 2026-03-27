from pathlib import Path

from arq import create_pool
from fastapi import FastAPI, WebSocket, WebSocketDisconnect
from fastapi.middleware.cors import CORSMiddleware

from .config import get_database_url, get_redis_settings, get_storage_root
from .db import create_db_pool, init_db
from .routers import admin, datasets, exports, legacy_compat, search, uploads

app = FastAPI(title="openPIP 2.0 API", version="0.2.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=[
        "http://localhost:3000",
        "http://127.0.0.1:3000",
    ],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.on_event("startup")
async def startup() -> None:
    app.state.db_pool = await create_db_pool(get_database_url())
    await init_db(app.state.db_pool)
    app.state.redis = await create_pool(get_redis_settings())
    app.state.storage_root = Path(get_storage_root())
    app.state.storage_root.mkdir(parents=True, exist_ok=True)


@app.on_event("shutdown")
async def shutdown() -> None:
    if app.state.redis is not None:
        await app.state.redis.close()
    await app.state.db_pool.close()


@app.get("/health")
async def health() -> dict:
    async with app.state.db_pool.acquire() as conn:
        await conn.fetchval("SELECT 1")
    return {"status": "ok"}


@app.websocket("/ws")
async def websocket_echo(ws: WebSocket) -> None:
    """Minimal websocket endpoint to prevent 403 for /ws probes during demo runs."""
    await ws.accept()
    await ws.send_json({"type": "connected", "message": "openPIP websocket endpoint"})
    try:
        while True:
            _ = await ws.receive_text()
            await ws.send_json({"type": "ack"})
    except WebSocketDisconnect:
        return


app.include_router(uploads.router)
app.include_router(search.router)
app.include_router(exports.router)
app.include_router(datasets.router)
app.include_router(admin.router)
app.include_router(legacy_compat.router)
