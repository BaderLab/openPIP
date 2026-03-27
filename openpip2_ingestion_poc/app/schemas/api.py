from __future__ import annotations

from datetime import datetime
from typing import Optional

from pydantic import BaseModel, Field


class JobCreateResponse(BaseModel):
    job_id: str
    queue_job_id: Optional[str]
    storage_key: str


class JobStatusResponse(BaseModel):
    id: str
    dataset_id: int
    stage: str
    status: str
    processed_rows: int
    inserted_rows: int
    skipped_rows: int
    failed_rows: int
    created_at: datetime
    updated_at: datetime


class JobErrorItem(BaseModel):
    id: int
    source_row: int
    error_code: str
    error_message: str
    remediation_hint: Optional[str] = None
    raw_payload: Optional[dict] = None
    created_at: datetime


class JobErrorListResponse(BaseModel):
    items: list[JobErrorItem]
    count: int


class SearchItem(BaseModel):
    id: int
    dataset_id: int
    interactor_a_ns: str
    interactor_a_id: str
    interactor_b_ns: str
    interactor_b_id: str
    interaction_type: Optional[str]
    confidence_score: Optional[float]
    publication_id: Optional[str]


class SearchResponse(BaseModel):
    items: list[SearchItem]
    count: int


class DatasetItem(BaseModel):
    id: int
    name: str
    description: Optional[str]
    source_file: Optional[str]
    interaction_count: int


class DatasetListResponse(BaseModel):
    items: list[DatasetItem]
    count: int


class CommitResponse(BaseModel):
    job_id: str
    queue_job_id: Optional[str]
    message: str


class UploadCreateRequest(BaseModel):
    dataset_id: int = Field(gt=0)
    parser_hint: str = "psi_mitab"
