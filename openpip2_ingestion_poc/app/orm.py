from __future__ import annotations

from datetime import datetime
from typing import Optional

from sqlalchemy import BigInteger, DateTime, Float, ForeignKey, Integer, String, Text, UniqueConstraint
from sqlalchemy.orm import DeclarativeBase, Mapped, mapped_column


class Base(DeclarativeBase):
    pass


class Dataset(Base):
    __tablename__ = "datasets"

    id: Mapped[int] = mapped_column(BigInteger, primary_key=True)
    name: Mapped[str] = mapped_column(Text)
    description: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    source_file: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    interaction_count: Mapped[int] = mapped_column(BigInteger, default=0)
    created_at: Mapped[datetime] = mapped_column(DateTime(timezone=True), default=datetime.utcnow)


class Protein(Base):
    __tablename__ = "proteins"

    id: Mapped[int] = mapped_column(BigInteger, primary_key=True)
    primary_id: Mapped[str] = mapped_column(Text, unique=True)
    gene_name: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    protein_name: Mapped[Optional[str]] = mapped_column(Text, nullable=True)


class Interaction(Base):
    __tablename__ = "interactions"
    __table_args__ = (UniqueConstraint("interaction_hash", name="uq_interactions_hash"),)

    id: Mapped[int] = mapped_column(BigInteger, primary_key=True)
    dataset_id: Mapped[int] = mapped_column(ForeignKey("datasets.id", ondelete="CASCADE"))
    pair_key: Mapped[str] = mapped_column(Text)
    interaction_hash: Mapped[str] = mapped_column(String(64))
    score: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    removed: Mapped[Optional[str]] = mapped_column(String(10), nullable=True, default="0")
    binding_start: Mapped[Optional[str]] = mapped_column(String(10), nullable=True)
    binding_end: Mapped[Optional[str]] = mapped_column(String(10), nullable=True)
    interactor_a_ns: Mapped[str] = mapped_column(Text)
    interactor_a_id: Mapped[str] = mapped_column(Text)
    interactor_b_ns: Mapped[str] = mapped_column(Text)
    interactor_b_id: Mapped[str] = mapped_column(Text)
    interaction_type: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    confidence_score: Mapped[Optional[float]] = mapped_column(Float, nullable=True)
    publication_id: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    source_file: Mapped[str] = mapped_column(Text)
    source_row: Mapped[int] = mapped_column(BigInteger)
    parser_version: Mapped[str] = mapped_column(Text)


class Annotation(Base):
    __tablename__ = "annotations"

    id: Mapped[int] = mapped_column(BigInteger, primary_key=True)
    interaction_id: Mapped[int] = mapped_column(ForeignKey("interactions.id", ondelete="CASCADE"))
    key: Mapped[str] = mapped_column(Text)
    value: Mapped[str] = mapped_column(Text)


class UploadFile(Base):
    __tablename__ = "upload_files"

    id: Mapped[str] = mapped_column(String(36), primary_key=True)
    dataset_id: Mapped[int] = mapped_column(ForeignKey("datasets.id", ondelete="CASCADE"))
    filename: Mapped[str] = mapped_column(Text)
    storage_key: Mapped[str] = mapped_column(Text)
    parser_hint: Mapped[str] = mapped_column(Text)


class UploadJob(Base):
    __tablename__ = "upload_jobs"

    id: Mapped[str] = mapped_column(String(36), primary_key=True)
    upload_file_id: Mapped[str] = mapped_column(ForeignKey("upload_files.id", ondelete="CASCADE"))
    dataset_id: Mapped[int] = mapped_column(BigInteger)
    storage_key: Mapped[str] = mapped_column(Text)
    parser_hint: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    stage: Mapped[str] = mapped_column(String(16))
    status: Mapped[str] = mapped_column(String(16), default="parsing")
    total_rows: Mapped[Optional[int]] = mapped_column(BigInteger, nullable=True)
    processed_rows: Mapped[int] = mapped_column(BigInteger, default=0)
    inserted_rows: Mapped[int] = mapped_column(BigInteger, default=0)
    skipped_rows: Mapped[int] = mapped_column(BigInteger, default=0)
    failed_rows: Mapped[int] = mapped_column(BigInteger, default=0)
    error_summary: Mapped[Optional[str]] = mapped_column(Text, nullable=True)


class UploadJobError(Base):
    __tablename__ = "upload_job_errors"

    id: Mapped[int] = mapped_column(BigInteger, primary_key=True)
    job_id: Mapped[str] = mapped_column(ForeignKey("upload_jobs.id", ondelete="CASCADE"))
    source_row: Mapped[int] = mapped_column(BigInteger)
    error_code: Mapped[str] = mapped_column(String(64))
    error_message: Mapped[str] = mapped_column(Text)
    remediation_hint: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
    raw_payload: Mapped[Optional[str]] = mapped_column(Text, nullable=True)
