from fastapi import APIRouter

from ..config import get_logto_issuer

router = APIRouter(prefix="/admin", tags=["admin"])


@router.get("/settings")
async def get_admin_settings():
    # Placeholder for dataset and annotation management settings.
    return {
        "dataset_management": True,
        "annotation_management": True,
        "auth_provider": "logto",
        "logto_issuer": get_logto_issuer(),
        "note": "Wire this endpoint to persistent settings storage in production.",
    }
