# openPIP 2.0 Conversion Scaffold

This folder contains a modern conversion of core openPIP behavior from the legacy Symfony/PHP codebase into:

- Backend: FastAPI + SQLAlchemy 2.x models + Pydantic v2 + ARQ + Redis
- Frontend: Next.js 14 + TypeScript + TanStack Query + Cytoscape.js
- Database: PostgreSQL (Apache AGE ready)
- Object storage: MinIO
- Auth integration point: Logto issuer config
- Runtime: Docker Compose

## Legacy to New Mapping

- Legacy DataController and DropzoneController flow:
  - upload, parsing, validation, queue handling
  - now in upload routes plus ARQ worker jobs
- Legacy SearchController:
  - now API-first search endpoint returning typed JSON
- Legacy DataDownloadController:
  - now export endpoints for CSV and PSI-MI TAB
- Legacy Interaction and Upload_Files entities:
  - mapped to SQLAlchemy models and db tables in this scaffold

## Backend Structure

- app/main.py: FastAPI app and router registration
- app/routers/uploads.py: upload jobs, errors, commit, SSE stream
- app/routers/search.py: typed search API
- app/routers/exports.py: CSV and MITAB exports
- app/routers/datasets.py: dataset browser API
- app/routers/admin.py: admin settings endpoint with Logto issuer
- app/services: service layer separation
- app/jobs.py: ARQ validation and commit pipeline
- app/parsers.py and app/parser.py: parser plugin contract and implementations
- app/db.py: async persistence and query helpers
- app/orm.py: SQLAlchemy models
- alembic: migration config and initial revision

## Two-Phase Upload and Ingestion

1. upload file using parser hint
2. validation job runs and stores row-level errors
3. review errors
4. explicit commit writes valid rows only

Job stages:
- queued
- parsing
- validating
- writing
- completed
- failed

Status states:
- parsing
- validated
- committed

## Parser Interface

Parser contract supports:
- sniff
- parse
- validate
- transform

Implemented parsers:
- PSI-MI TAB parser with confidence normalization:
  - score:0.85
  - intact-miscore:0.43
  - raw float format
- CSV parser with matching contract

## Duplicate Detection

Hash-based deduplication is applied at insert time:
- hash key is derived from dataset_id and sorted interactor pair
- unique index on interaction_hash
- skipped duplicates are tracked in skipped_rows

## API Endpoints

- POST /uploads/jobs
- GET /uploads/jobs/{job_id}
- GET /uploads/jobs/{job_id}/events
- POST /uploads/jobs/{job_id}/commit
- GET /uploads/jobs/{job_id}/errors
- GET /uploads/jobs/{job_id}/errors/export
- GET /search
- GET /datasets
- GET /exports/datasets/{dataset_id}/csv
- GET /exports/datasets/{dataset_id}/mitab
- GET /admin/settings

Legacy-compatible routes converted from Symfony controllers:
- GET /admin/media/upload
- POST /admin/media/upload/process/{dir_name}
- GET /admin/data_manager/{folder}/{file}
- POST /admin/data_manager/insert_data/{folder}/{file}
- GET /download/interaction_csv/{search_term}
- GET /download/interactor_csv/{search_term}
- GET /download/psi_mitab/{search_term}
- GET /search/{search_term}
- GET /search_results/{search_term}
- GET /admin/search/{search_term}
- GET or POST /search_results_interactions

## Run with Docker Compose

From this directory:

```bash
docker compose up --build
```

Services:
- api at http://localhost:8000
- frontend at http://localhost:3000
- postgres at localhost:5433
- redis at localhost:6380
- minio api at http://localhost:9000
- minio console at http://localhost:9001

## Run Without Docker

You can run the full demo without Docker by using:
- local FastAPI server
- local Next.js server
- SYNC_JOB_MODE so uploads run immediately without Redis worker
- any managed Postgres connection string (Neon, Supabase, Railway)

PowerShell steps:

  cd openpip2_ingestion_poc
  py -3.11 -m venv .venv
  .\.venv\Scripts\Activate.ps1
  pip install -r requirements.txt

Set environment variables:

  $env:DATABASE_URL="postgresql://USER:PASSWORD@HOST:5432/DBNAME"
  $env:STORAGE_ROOT="./data/uploads"
  $env:PARSER_VERSION="psi_mitab_core15_v1"
  $env:SYNC_JOB_MODE="1"

Run backend:

  uvicorn app.main:app --host 0.0.0.0 --port 8000

In a second terminal run frontend:

  cd openpip2_ingestion_poc\frontend
  npm install
  $env:NEXT_PUBLIC_API_BASE="http://localhost:8000"
  npm run dev

Open the app at http://localhost:3000

Notes:
- In SYNC_JOB_MODE, you do not need Redis or the ARQ worker process.
- MinIO is optional in this local demo path because file storage uses STORAGE_ROOT.

## Curl Demo

Upload a PSI-MI TAB file:

```bash
curl -X POST http://localhost:8000/uploads/jobs \
  -F "dataset_id=42" \
  -F "parser_hint=psi_mitab" \
  -F "file=@sample_data/mitab_demo.tsv"
```

Get job status:

```bash
curl http://localhost:8000/uploads/jobs/JOB_ID
```

Stream live progress over SSE:

```bash
curl -N http://localhost:8000/uploads/jobs/JOB_ID/events
```

Fetch row errors:

```bash
curl "http://localhost:8000/uploads/jobs/JOB_ID/errors?limit=100&offset=0"
```

Download error CSV:

```bash
curl http://localhost:8000/uploads/jobs/JOB_ID/errors/export -o errors.csv
```

Commit validated rows:

```bash
curl -X POST http://localhost:8000/uploads/jobs/JOB_ID/commit
```

Export interactions as CSV:

```bash
curl http://localhost:8000/exports/datasets/42/csv -o interactions.csv
```

Export interactions as PSI-MI TAB:

```bash
curl http://localhost:8000/exports/datasets/42/mitab -o interactions.mitab
```

Search interactions:

```bash
curl "http://localhost:8000/search?q=P12345&dataset_id=42&limit=50&offset=0"
```

## Tests

Run parser unit tests and integration test:

```bash
pytest tests/test_parser_mitab.py tests/test_parser_csv.py tests/test_integration_upload_commit.py
```

Integration test requires PostgreSQL to be reachable on localhost:5433.
