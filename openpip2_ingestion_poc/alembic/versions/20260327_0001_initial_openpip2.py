"""initial openpip2 schema

Revision ID: 20260327_0001
Revises:
Create Date: 2026-03-27
"""

from alembic import op
import sqlalchemy as sa


revision = "20260327_0001"
down_revision = None
branch_labels = None
depends_on = None


def upgrade() -> None:
    op.create_table(
        "datasets",
        sa.Column("id", sa.BigInteger(), primary_key=True),
        sa.Column("name", sa.Text(), nullable=False),
        sa.Column("description", sa.Text(), nullable=True),
        sa.Column("source_file", sa.Text(), nullable=True),
        sa.Column("interaction_count", sa.BigInteger(), nullable=False, server_default="0"),
        sa.Column("created_at", sa.DateTime(timezone=True), server_default=sa.text("now()"), nullable=False),
    )

    op.create_table(
        "proteins",
        sa.Column("id", sa.BigInteger(), primary_key=True),
        sa.Column("primary_id", sa.Text(), nullable=False, unique=True),
        sa.Column("gene_name", sa.Text(), nullable=True),
        sa.Column("protein_name", sa.Text(), nullable=True),
    )

    op.create_table(
        "interactions",
        sa.Column("id", sa.BigInteger(), primary_key=True),
        sa.Column("dataset_id", sa.BigInteger(), sa.ForeignKey("datasets.id", ondelete="CASCADE"), nullable=False),
        sa.Column("pair_key", sa.Text(), nullable=False),
        sa.Column("interaction_hash", sa.String(length=64), nullable=False),
        sa.Column("score", sa.Text(), nullable=True),
        sa.Column("removed", sa.String(length=10), nullable=True, server_default="0"),
        sa.Column("binding_start", sa.String(length=10), nullable=True),
        sa.Column("binding_end", sa.String(length=10), nullable=True),
        sa.Column("interactor_a_ns", sa.Text(), nullable=False),
        sa.Column("interactor_a_id", sa.Text(), nullable=False),
        sa.Column("interactor_b_ns", sa.Text(), nullable=False),
        sa.Column("interactor_b_id", sa.Text(), nullable=False),
        sa.Column("interaction_type", sa.Text(), nullable=True),
        sa.Column("confidence_score", sa.Float(), nullable=True),
        sa.Column("publication_id", sa.Text(), nullable=True),
        sa.Column("source_file", sa.Text(), nullable=False),
        sa.Column("source_row", sa.BigInteger(), nullable=False),
        sa.Column("parser_version", sa.Text(), nullable=False),
    )
    op.create_unique_constraint("uq_interactions_hash", "interactions", ["interaction_hash"])

    op.create_table(
        "annotations",
        sa.Column("id", sa.BigInteger(), primary_key=True),
        sa.Column("interaction_id", sa.BigInteger(), sa.ForeignKey("interactions.id", ondelete="CASCADE"), nullable=False),
        sa.Column("key", sa.Text(), nullable=False),
        sa.Column("value", sa.Text(), nullable=False),
    )

    op.create_table(
        "upload_files",
        sa.Column("id", sa.String(length=36), primary_key=True),
        sa.Column("dataset_id", sa.BigInteger(), sa.ForeignKey("datasets.id", ondelete="CASCADE"), nullable=False),
        sa.Column("filename", sa.Text(), nullable=False),
        sa.Column("storage_key", sa.Text(), nullable=False),
        sa.Column("parser_hint", sa.Text(), nullable=False),
    )

    op.create_table(
        "upload_jobs",
        sa.Column("id", sa.String(length=36), primary_key=True),
        sa.Column("upload_file_id", sa.String(length=36), sa.ForeignKey("upload_files.id", ondelete="CASCADE"), nullable=False),
        sa.Column("dataset_id", sa.BigInteger(), nullable=False),
        sa.Column("storage_key", sa.Text(), nullable=False),
        sa.Column("parser_hint", sa.Text(), nullable=True),
        sa.Column("stage", sa.String(length=16), nullable=False),
        sa.Column("status", sa.String(length=16), nullable=False, server_default="parsing"),
        sa.Column("total_rows", sa.BigInteger(), nullable=True),
        sa.Column("processed_rows", sa.BigInteger(), nullable=False, server_default="0"),
        sa.Column("inserted_rows", sa.BigInteger(), nullable=False, server_default="0"),
        sa.Column("skipped_rows", sa.BigInteger(), nullable=False, server_default="0"),
        sa.Column("failed_rows", sa.BigInteger(), nullable=False, server_default="0"),
        sa.Column("error_summary", sa.Text(), nullable=True),
    )

    op.create_table(
        "upload_job_errors",
        sa.Column("id", sa.BigInteger(), primary_key=True),
        sa.Column("job_id", sa.String(length=36), sa.ForeignKey("upload_jobs.id", ondelete="CASCADE"), nullable=False),
        sa.Column("source_row", sa.BigInteger(), nullable=False),
        sa.Column("error_code", sa.String(length=64), nullable=False),
        sa.Column("error_message", sa.Text(), nullable=False),
        sa.Column("remediation_hint", sa.Text(), nullable=True),
        sa.Column("raw_payload", sa.Text(), nullable=True),
    )


def downgrade() -> None:
    op.drop_table("upload_job_errors")
    op.drop_table("upload_jobs")
    op.drop_table("upload_files")
    op.drop_table("annotations")
    op.drop_constraint("uq_interactions_hash", "interactions", type_="unique")
    op.drop_table("interactions")
    op.drop_table("proteins")
    op.drop_table("datasets")
