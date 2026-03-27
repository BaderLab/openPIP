## About Me

Full Name: Aryan Mishra
Email: aryanmi2001@gmail.com
Discord: alaotach
GitHub: https://github.com/alaotach
Time Zone: UTC+05:30
University: Jawaharlal Nehru University
Program and Year: B.Tech, 2nd Year
Expected Graduation: 2028
Resume: [View Resume](https://drive.google.com/file/d/1hnyt2KPOfiS1uNWjsXIU33ENeKOni_Yh/view?usp=sharing)

---

## Proposal Title

openPIP 2.0: A Ground-Up Rewrite with Multi-Format Molecular Interaction Ingestion, Admin UX Revamp, and Container-First Deployment

---

## Abstract

I first came across openPIP while looking for open-source bioinformatics tooling that was actually maintained. The science behind it is solid. The data it hosts is genuinely useful. But the moment I started reading the codebase, something became obvious: the platform has outgrown its own architecture. Years of incremental additions have layered routing, parsing, persistence, and rendering logic on top of each other in ways that make every change feel risky and every new feature feel harder than it should be.

This proposal is about fixing that. Not patching it, not working around it, but doing the rewrite properly.

openPIP 2.0 will move the backend to FastAPI with typed schemas and clean service boundaries, replace the frontend with Next.js 14 and TypeScript for a responsive admin and public portal experience, and introduce an ingestion pipeline built from the ground up for multiple formats, starting with PSI-MI TAB and CSV. Upload workflows will be async, observable, and failure-friendly, with row-level diagnostics that tell curators exactly what went wrong and why. The whole thing runs in Docker, ships with CI, and is built to be the kind of codebase a new contributor can actually navigate on their first day.

I have already built a working proof-of-concept covering the core ingestion architecture. This proposal is not speculation. The hard parts are already figured out.

---

## 0.1 Proof of Concept: What I Already Built

Before writing a single line of this proposal, I spent time actually reading the openPIP source. Not skimming it. Reading it. I traced the upload flow from the Dropzone controller through the data manager insert path, read the legacy SQL schema, and mapped out where the real complexity lives. Then I built a PoC to validate that the architecture I was proposing could actually work.

The PoC (`openpip2_ingestion_poc`) covers the full ingestion pipeline end to end.

**What it does**

A FastAPI backend with modular routers, a proper service layer, a parser abstraction, and a DB layer that actually separates concerns. A two-phase ingestion workflow where validation runs first and commit only happens after the user reviews what passed and what failed. Row-level errors stored with remediation hints so curators are not left guessing. A CSV export for failed rows so people can fix and re-upload. A parser plugin contract with two real implementations already working. Duplicate detection with inserted-versus-skipped counters. A Next.js frontend wired to the backend job lifecycle with live progress via Server-Sent Events.

**The ingestion flow, step by step**

Upload creates a job and stores file metadata. The validation worker parses rows and records structured errors. The user reviews what passed, what failed, and why. Commit writes the valid interactions to the canonical model. Final counters stay queryable for auditability. This is safer than a blind single-step import and it actually supports real curation practices where data quality matters.

**Where the code lives (and why it matters)**

The PoC is intentionally structured around boundaries that mirror the pain points in the legacy system. `app/main.py` keeps bootstrap and router wiring minimal so behavior is not hidden in framework glue. `app/services/upload_service.py` owns orchestration and input hardening so upload rules are not duplicated across routes. `app/jobs.py` cleanly separates validation from commit, which is what enables review-before-write behavior. `app/db.py` centralizes persistence decisions, including deterministic deduplication keys, so correctness does not depend on parser-specific branches. Parsing responsibilities are split between `app/parsers.py` (plugin contract and parser selection) and `app/parser.py` (PSI-MI normalization details like identifier and confidence handling). On the UI side, `frontend/components/upload-manager.tsx` is the control loop that binds job lifecycle state, SSE progress, and commit decisions into a curator-facing workflow.

**Legacy-to-modern mapping**

This is not abstract equivalence. Every legacy responsibility has a concrete modern counterpart I can point to:

The legacy upload entrypoint in `DropzoneController.php` maps to the compatibility upload endpoint in `legacy_compat.py` and the core upload service. The legacy insert workflow in `DataController.php` maps to the queued validate and commit jobs. The legacy data-manager insertion path maps to the compatibility route. The legacy search route maps to the compatibility search endpoint.

This explicit mapping matters because it reduces regression risk during staged cutover and gives mentors something concrete to review rather than taking my word for it.

**What the PoC proves and where it stops**

It proves the core ingestion redesign is technically viable end to end. It proves legacy behavior can be wrapped and migrated incrementally without a big-bang cutover. It proves upload observability and data quality workflows are substantially better than what exists today.

What it does not do: full edge-case parity with every legacy controller, production-grade hardening, or comprehensive test coverage beyond the core flows. Those are GSoC work, not PoC work.

---

## 1. Why This Project Matters

Let me be honest about something. When I describe openPIP's technical debt, it is easy for that to sound like an abstract engineering complaint. But there is a real human cost to it.

A researcher or curator trying to import a new interaction dataset today has no idea what happened if the import fails. There is no row-level feedback. There is no structured error report. There is no way to partially accept a file and fix the rest. The import either works or it does not, and if it does not, good luck figuring out why. That is not a codebase problem. That is a workflow problem that affects real people trying to do real science.

That is what openPIP 2.0 is actually fixing.

**What is broken technically**

The legacy Symfony kernel and bundle architecture makes adding anything new an exercise in archaeology. Routing mixes framework-generated and manually declared routes with duplicate keys that have probably caused confusion more than once. Upload and ingestion logic is tightly coupled to controllers and filesystem paths, which means testing any of it in isolation is basically impossible. PSI-MI tab parsing is embedded inside request handlers with repeated line-based parsing loops scattered across three different locations in DataController. Export pathways are format-specific and controller-heavy. Search mixes query parsing, aggregation, response packaging, and rendering in a single place. The runtime is anchored to older PHP and Apache baselines.

None of this is anyone's fault. It is what happens when a useful project grows organically without dedicated engineering resources to periodically clean up the architecture. But it does mean that the cost of every new feature keeps going up, and the risk of every change stays uncomfortably high.

**What openPIP 2.0 fixes**

New interaction data formats can be added through a plugin contract without touching core logic. Upload validation gives curators row-level feedback with remediation hints. Import failures are structured, exportable, and actionable. The codebase has actual service boundaries that can be tested in isolation. A new contributor can get a local environment running in one command and understand where things live without a tour guide.

---

## 2. Understanding the Existing System

I did not design openPIP 2.0 from first principles and then go look at the code. I read the code first, then designed the architecture to match what actually needed to change.

**Domain and persistence anchors worth keeping**

The existing schema has real scientific value in its domain concepts. The interaction table, protein table, dataset table, and annotation table all represent meaningful entities that should be preserved and normalized in the new model, not thrown away. The Doctrine entity mappings in `Interaction.php` and `Upload_Files.php` informed the canonical model design directly.

**Current ingestion and file handling**

The upload endpoint in `DropzoneController.php` handles file intake and moves files to a directory. The data manager insert path in `DataController.php` handles parsing and persistence. These two responsibilities are coupled in ways that make them hard to test, observe, or extend. Separating them cleanly is one of the most important things openPIP 2.0 does.

**Current deployment model**

The existing Docker Compose setup runs PHP and MySQL together with an older Apache/PHP image baseline. It works, but it does not reflect modern deployment practices and makes local development setup more fragile than it needs to be.

---

## 3. Architecture for openPIP 2.0

### Goals

Preserve scientific workflow correctness above everything else. Separate ingestion, validation, persistence, and query surfaces so each can evolve independently. Enable multi-format support through a parser plugin system. Give upload workflows first-class observability and failure diagnostics. Keep deployments reproducible and contributor-friendly.

### Technology Stack

Frontend: Next.js 14 with App Router, TypeScript, TanStack Query, React Hook Form, and Zod for runtime validation.

Backend: FastAPI, SQLAlchemy 2.x, Pydantic, Alembic for migrations.

Async tasks: ARQ with Redis for ingestion workers and live progress updates.

Database: PostgreSQL as the system of record, with optional Apache AGE for graph traversals if needed.

File storage: MinIO (S3-compatible) for raw uploads and import artifacts.

Auth: Logto (OIDC/OAuth2) for admin, curator, and public role flows.

Containerization: Docker Compose for development and CI reproducibility.

Deployment target: Coolify for self-hosted deployment, with a cloud migration path available.

CI: GitHub Actions for lint, type checks, test matrix, and image build smoke checks.

### On the database question

I want to address this directly because it is the kind of decision that can derail a GSoC project if it is not thought through carefully.

I am proposing PostgreSQL as the single primary database. Not PostgreSQL plus Neo4j. Not a dual-database setup that doubles the operational complexity and the contributor setup burden. PostgreSQL, with Apache AGE as an optional extension for graph traversals if profiling shows it is actually needed.

Neo4j is a valid tool for certain graph-heavy workloads. But for the interaction counts openPIP deals with, PostgreSQL with proper indexes and materialized views will handle the query patterns without introducing a second database system that every contributor needs to run locally. If a future profiling run proves that wrong, adding a Neo4j adapter is a well-defined piece of work. Making it a core dependency upfront is not a risk I think the project should take.

### Service boundaries

API Gateway: auth, request validation, pagination, filtering. Upload Service: file intake, checksum, storage, job enqueue. Parser Service: format-specific parsers implementing a shared contract. Interaction Service: canonical interaction model orchestration. Annotation Service: molecule metadata enrichment. Export Service: PSI-MI TAB and CSV exports from canonical records. Search Service: interaction graph retrieval and query responses.

---

## 4. Data Model and Ingestion Design

### Canonical normalized model

The canonical interaction record decouples storage from file format specifics. This is the core architectural decision that makes multi-format support possible without special-casing every parser.

Core entities: Molecule, Interaction, InteractionEvidence, Dataset, Annotation, SourceRecord for raw row provenance, UploadJob, and UploadJobRowError. This preserves the domain concepts from the existing schema while adding explicit provenance and validation traces per ingested row.

### Parser plugin contract

Every parser implements the same interface: sniff a file and return a confidence score for whether it can handle the format, parse a stream and return an iterator of raw interaction records, validate a record and return structured errors, transform a valid record into a CanonicalInteraction.

Initial parsers shipping with the project: PsiMiTabParser for PSI-MI TAB 2.5 and 2.6, CsvInteractionParser for a curated CSV schema with explicit column mapping.

### Validation strategy

Schema validation catches missing columns, delimiter problems, and encoding issues before any domain logic runs. Domain validation checks interactor identifier formats, taxon constraints, and score normalization ranges. Referential validation checks dataset and annotation type consistency. Duplicate detection uses a deterministic hash of the interaction pair and evidence identifiers, with explicit counters for inserted, skipped, and failed rows.

### Row-level error UX

Every failed row surfaces a row index, an error code, a human-readable explanation, and a remediation hint. This is not a nice-to-have. It is the difference between a curator being able to fix a file and re-upload it versus giving up and asking for help on a mailing list.

---

## 5. Upload and Admin Experience

The current upload flow is endpoint-centric. You upload a file, something happens, and you either get data or you do not. openPIP 2.0 replaces that with a job-oriented pipeline that treats every import as an observable, recoverable operation.

**New upload workflow**

The user drags one or more files into the uploader. The client performs immediate preflight checks on file size, extension, and delimiter sampling. The backend creates an UploadJob and returns a job ID. A worker parses and validates asynchronously. The UI subscribes to progress updates via Server-Sent Events and shows row-level diagnostics as they come in. The user reviews the validation stage, sees counters for passed and failed rows, and decides whether to commit, download an error report, or retry with a corrected file.

**UX details that matter**

A bulk upload queue with per-file status. Live progress bars with explicit stage labels: queued, parsing, validating, writing, completed, failed. An error panel filterable by error code and row index. A one-click download for the error report as CSV or JSON. A re-run option for CSV column mapping mistakes without re-uploading the file.

**Admin controls**

Dataset metadata management. Annotation type mapping rules. Controlled vocabulary mapping for interaction methods and evidence types. Audit trail for uploads and user actions.

---

## 6. Metadata and Annotation Enrichment

The goal is to support importing molecule metadata from public sources like UniProt and NCBI, attached as versioned annotations with full provenance tracking.

Every annotation stores the source, fetch timestamp, and version snapshot at the time of enrichment. Re-enrichment only happens under explicit user action, never silently. This keeps the data auditable and reproducible, which matters for scientific workflows in a way that it might not matter for other types of applications.

---

## 7. API and Frontend Contract

**API surface**

Upload APIs handle job creation, file append, progress polling, row error retrieval, and commit approval. Interaction APIs support querying by molecule, dataset, evidence type, and status. Export APIs cover PSI-MI TAB, CSV, and filtered exports. Metadata APIs expose annotation types, enrichment status, and mapping dictionaries. Admin APIs handle dataset and portal configuration.

**Frontend panes**

Upload Manager, Dataset Manager, Search and Results Visualization, Interaction Detail Drawer, Export Panel, Admin Settings.

**On graph rendering**

The primary library for PPI network visualization will be Cytoscape.js. It handles pan, zoom, layout switching, edge filtering, node search, and subgraph export well for biological graph sizes. D3.js is reserved for custom charts like score distributions or upload quality histograms, not the main interaction graph. React Flow handles admin-only workflow views like ingestion pipeline stages and job state diagrams.

This separation is deliberate. Each library is doing what it is actually good at rather than one library being stretched to cover everything.

**Search modernization**

The current search controller mixes query parsing, aggregation, response packaging, and rendering in one place. The new architecture moves query logic entirely to a backend service and gives the frontend a clean typed API response to render. No more mixed concerns.

---

## 8. Migration Plan

The migration plan follows one rule: no big-bang cutover without data parity checks.

The steps are: build the canonical schema and migration scripts, import the existing SQL snapshot, backfill the canonical model from legacy entities, run parity checks for key queries and export counts, enable dual-run verification on representative datasets, cut over UI and API once parity thresholds pass.

Parity checks cover total protein count, total interaction count, query response equivalence for known test terms, and export row counts for both PSI-MI TAB and CSV.

The legacy compatibility shim stays live throughout this process so nothing breaks for consumers that have not migrated yet.

---

## 9. Infrastructure

**New Docker Compose topology**

Six services: Next.js frontend, FastAPI API, ARQ worker, Redis task broker, PostgreSQL database, MinIO object storage. No sync mode fallbacks. Redis and PostgreSQL are required at startup and enforced through configuration validation.

**CI pipeline**

Backend lint and type checks. Frontend lint and type checks. Unit tests. Integration tests with ephemeral PostgreSQL and Redis. Container build validation. Everything runs on GitHub Actions.

---

## 10. Testing Strategy

Unit tests cover parsers for both PSI-MI TAB and CSV, domain validators, service-level deduplication and conflict resolution, and annotation mappers.

Integration tests cover the full upload job lifecycle, parser-to-database persistence flow, search endpoint response contracts, and export correctness.

Regression and data-quality tests use golden datasets with expected interaction counts, snapshot tests for normalized output records, and round-trip tests that go import to canonical to export and verify the output matches.

Frontend tests cover the upload queue and progress state components, interaction and result panel rendering, and error table filtering and remediation flows.

---

## 11. Risks and Mitigation

The highest implementation risk is format mismatch between PSI-MI TAB and curated CSV ingestion paths. I handle that by pushing both through a canonical transform layer with per-format adapters and explicit provenance, so behavior differences are visible, testable, and reversible.

Performance risk is concentrated in large-file ingestion. The mitigation is architectural, not cosmetic: chunked streaming parse, async workers, batched writes, and index-aware query paths from day one rather than post-hoc tuning.

For graph/query complexity, I am deliberately avoiding premature multi-database architecture. PostgreSQL remains the core system with indexes and materialized views; Apache AGE is an optional extension for targeted traversals if profiling proves a need. Neo4j stays an evaluation path, not a hard dependency during the core timeline.

Migration risk is controlled with parity harness checks, dual-run verification, and staged cutover. The compatibility layer remains active during migration so existing consumers are not forced into a big-bang switch.

Scope risk in a 12-week window is addressed by making non-goals explicit in planning: no custom multi-hop graph query language, no required Neo4j production dependency, no broad multi-provider metadata federation, no workflow engine beyond ingestion/validation, and no deep analytics dashboarding in core delivery. These are deferred intentionally to protect a reliable, reviewable core milestone set.

---

## 12. Deliverables

**Core**

Backend scaffold with typed APIs: `/health`, `/uploads/jobs`, `/uploads/jobs/{id}`, `/interactions/search`, and export endpoints implemented and covered by integration tests, with OpenAPI docs generated in CI.

Upload and admin interface with drag-drop and progress telemetry: multi-file upload queue supporting at least three concurrent files, each exposing stage states and a downloadable row-error report.

PSI-MI TAB parser, production-ready: supports MITAB 2.5 and 2.6 core 15 columns, handles pipe-delimited multi-value fields, stores normalized interactors and evidence, and imports a 100k-row benchmark file with resumable progress tracking.

CSV parser with explicit column mapping: curated CSV template plus a user mapping UI, validation catching missing mandatory columns and bad identifier patterns, import path writing to the same canonical schema as PSI-MI.

Canonical interaction model with provenance tracking: every imported interaction links to dataset ID, source file, source row, parser version, and row-level validation status.

Export module for PSI-MI TAB and CSV: filtered exports match canonical query results, parity tests verify row counts and mandatory column coverage against golden fixtures.

Containerized development and CI pipeline: one-command local startup, CI running lint, type checks, unit and integration tests, and container build smoke tests.

Website graph visualization for PPI exploration: Cytoscape.js view supporting pan, zoom, layout switching, edge filtering by dataset and evidence, node search, and subgraph export.

Documentation and contributor onboarding: setup docs, architecture notes, parser extension guide, and troubleshooting page for failed imports, all reproducible on a clean machine.

**Stretch**

Additional file formats beyond the initial CSV schema. Advanced molecule metadata enrichment source federation. Performance dashboard for ingestion metrics. Neo4j adapter behind a feature flag if profiling demonstrates the need.

---

## 13. Weekly Timeline

**Week 1: Scope lock**
Finalize acceptance criteria with mentors. Confirm schema boundaries and migration strategy. Produce a technical design document that gives mentors a clear picture of what is being built and how decisions were made.

**Week 2: Scaffolding and infrastructure**
Initialize the monorepo structure. Get Docker Compose running locally. Establish the CI baseline. The goal is a runnable skeleton that proves the infrastructure assumptions are correct.

**Week 3: Canonical schema and migrations**
Implement the core domain schema. Set up Alembic migrations. Create seed scripts and fixture datasets. Everything downstream depends on getting this right.

**Week 4: Upload job pipeline**
File intake endpoints. Async job queue and progress states. Job status APIs. By the end of this week the skeleton of the ingestion pipeline should be wired together even if the parsers are not real yet.

**Week 5: PSI-MI TAB parser alpha**
Streaming parser for core MITAB columns. Validation engine for column cardinality and identifier formats. Initial persistence transform path and row error capture. Fixture-based tests and resumable job progress.

**Week 6: PSI-MI TAB hardening**
Multi-value field handling. Duplicate detection, identifier normalization, and persistence tuning. Benchmark import testing and failure recovery. By the end of this week PSI-MI ingestion should be production-ready.

**Week 7: CSV parser and mapping UI**
CSV parser contract implementation. Column mapping and mandatory field validation. Bulk upload queue refinements. CSV parser alpha with mapper UI and row-level errors.

**Week 8: CSV hardening and canonical parity**
Canonical transform parity checks between CSV and PSI-MI ingestion output. Conflict resolution and deduplication behavior validation. Import retries and idempotency checks.

**Week 9: Search and query service**
Rebuild query APIs replacing the mixed controller rendering. Graph payload generation. Pagination and filtering.

**Week 10: Export module and parity checks**
PSI-MI TAB and CSV exports from the canonical model. Export parity tests against legacy behavior.

**Week 11: Frontend UX and admin workflows**
Upload error remediation UX. Dataset and admin management pages. Accessibility and responsiveness pass.

**Week 12: Hardening, docs, and handoff**
Load test the ingestion path. Database index tuning. Failure and retry behavior hardening. Contributor guide and architecture docs. User docs and migration notes. Final evaluation prep.

---

## 14. Why Me

I want to be straightforward here rather than list generic skills.

I have been building things seriously for about five years. Not just learning, actually shipping. Discord bots for clients and friends, freelance web projects, a decentralized compute network, trading systems, a handful of half-finished side projects that taught me more than the finished ones did. I am comfortable picking up an unfamiliar codebase and figuring out where things live. I do that by reading the code, not by asking someone to explain it to me.

For this proposal specifically, I read the openPIP source before I wrote a single line of the proposal. I traced the upload flow, read the legacy SQL schema, mapped the legacy controllers to the responsibilities they actually own, and then built a working PoC to validate the architecture I was proposing. That PoC is linked in this proposal. It is not a mockup. It runs.

The technical work this project requires sits right in the middle of things I have actually done: converting monolithic request-layer logic into service boundaries, designing parser pipelines that handle multiple formats with strict validation, building admin UIs with observable async workflows, and delivering in iterative milestones rather than big-bang PRs. I know what it feels like when a refactor goes sideways because the boundaries were not clear enough. I have made that mistake before and I know how to avoid it.

I am in my second year at JNU, studying and building in parallel. I have the time, the focus, and genuinely the interest in this project specifically. Bioinformatics tooling that is actually maintainable is a gap worth closing. I want to be the person who closes it for openPIP.

---

## 15. Code-Level Architecture

### PSI-MI TAB parser

```python
from dataclasses import dataclass
from typing import Iterator

MITAB_MIN_COLUMNS = 15

@dataclass
class PsiMiCore15:
    id_a: str
    id_b: str
    alt_id_a: str
    alt_id_b: str
    alias_a: str
    alias_b: str
    detection_method: str
    publication_first_author: str
    publication_id: str
    taxid_a: str
    taxid_b: str
    interaction_type: str
    source_db: str
    interaction_id: str
    confidence: str


def _split_multivalue(value: str) -> list[str]:
    if not value or value == "-":
        return []
    return [v.strip() for v in value.split("|") if v.strip() and v.strip() != "-"]


def _extract_identifier(raw: str) -> tuple[str | None, str | None]:
    token = _split_multivalue(raw)[0] if _split_multivalue(raw) else ""
    if ":" not in token:
        return None, None
    ns, value = token.split(":", 1)
    return ns.lower(), value.strip()


def _parse_confidence(raw: str) -> float | None:
    for token in _split_multivalue(raw):
        if token.startswith("intact-miscore:"):
            try:
                return float(token.split(":", 1)[1])
            except ValueError:
                return None
    return None


def parse_mitab_core_rows(lines: Iterator[str]) -> Iterator[tuple[int, PsiMiCore15]]:
    for row_no, line in enumerate(lines, start=1):
        if not line.strip() or line.startswith("#"):
            continue
        cols = line.rstrip("\n").split("\t")
        if len(cols) < MITAB_MIN_COLUMNS:
            raise ValueError(f"Row {row_no}: expected >=15 columns, found {len(cols)}")
        yield row_no, PsiMiCore15(*cols[:15])
```

### Canonical transform

```python
def to_canonical(row_no: int, rec: PsiMiCore15, dataset_id: int) -> dict:
    ns_a, val_a = _extract_identifier(rec.id_a)
    ns_b, val_b = _extract_identifier(rec.id_b)
    if not val_a or not val_b:
        raise ValueError(f"Row {row_no}: missing canonical interactor ids")

    pair_key = "::".join(sorted([f"{ns_a}:{val_a}", f"{ns_b}:{val_b}"]))
    methods = _split_multivalue(rec.detection_method)
    confidence_score = _parse_confidence(rec.confidence)

    return {
        "dataset_id": dataset_id,
        "pair_key": pair_key,
        "interactor_a_ns": ns_a,
        "interactor_a_id": val_a,
        "interactor_b_ns": ns_b,
        "interactor_b_id": val_b,
        "methods": methods,
        "publication_id": rec.publication_id,
        "interaction_type": rec.interaction_type,
        "confidence_score": confidence_score,
        "source_row": row_no,
    }
```

### ARQ ingestion worker

```python
async def ingest_upload_job(ctx, job_id: str, storage_key: str, parser_hint: str | None = None) -> dict:
    db = ctx["db"]
    store = ctx["object_store"]

    await db.jobs.set_stage(job_id, "parsing")
    stream = await store.open_text(storage_key)

    inserted = 0
    failed = 0
    batch: list[dict] = []

    try:
        for row_no, rec in parse_mitab_core_rows(stream):
            await db.jobs.set_progress(job_id, row_no=row_no)
            try:
                canonical = to_canonical(row_no, rec, dataset_id=await db.jobs.dataset_id(job_id))
                batch.append(canonical)
            except Exception as exc:
                failed += 1
                await db.job_errors.add(job_id, row_no=row_no, code="ROW_VALIDATION", message=str(exc))

            if len(batch) >= 1000:
                await db.interactions.bulk_upsert(batch)
                inserted += len(batch)
                batch.clear()
                await db.jobs.set_stage(job_id, "writing")

        if batch:
            await db.interactions.bulk_upsert(batch)
            inserted += len(batch)

        await db.jobs.complete(job_id, inserted=inserted, failed=failed)
        return {"job_id": job_id, "inserted": inserted, "failed": failed}
    except Exception as exc:
        await db.jobs.fail(job_id, reason=str(exc))
        raise
```

### Data parity harness

```python
def assert_parity(legacy_stats: dict, new_stats: dict) -> None:
    required = ["protein_count", "interaction_count", "dataset_count"]
    for key in required:
        if legacy_stats[key] != new_stats[key]:
            raise AssertionError(
                f"Parity mismatch for {key}: legacy={legacy_stats[key]} new={new_stats[key]}"
            )

def assert_query_fixture_parity(legacy_rows: list[dict], new_rows: list[dict]) -> None:
    legacy_pairs = {tuple(sorted([r["a"], r["b"]])) for r in legacy_rows}
    new_pairs = {tuple(sorted([r["a"], r["b"]])) for r in new_rows}
    if legacy_pairs != new_pairs:
        missing = legacy_pairs - new_pairs
        extra = new_pairs - legacy_pairs
        raise AssertionError(f"Pair mismatch: missing={len(missing)} extra={len(extra)}")
```

### Core SQL schema

```sql
CREATE TABLE upload_jobs (
    id UUID PRIMARY KEY,
    dataset_id BIGINT NOT NULL,
    storage_key TEXT NOT NULL,
    parser_hint TEXT,
    stage TEXT NOT NULL CHECK (stage IN ('queued','parsing','validating','writing','completed','failed')),
    total_rows BIGINT,
    processed_rows BIGINT NOT NULL DEFAULT 0,
    inserted_rows BIGINT NOT NULL DEFAULT 0,
    failed_rows BIGINT NOT NULL DEFAULT 0,
    error_summary TEXT,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    updated_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE upload_job_errors (
    id BIGSERIAL PRIMARY KEY,
    job_id UUID NOT NULL REFERENCES upload_jobs(id) ON DELETE CASCADE,
    source_row BIGINT NOT NULL,
    error_code TEXT NOT NULL,
    error_message TEXT NOT NULL,
    raw_payload JSONB,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE interactions (
    id BIGSERIAL PRIMARY KEY,
    dataset_id BIGINT NOT NULL,
    pair_key TEXT NOT NULL,
    interactor_a_ns TEXT NOT NULL,
    interactor_a_id TEXT NOT NULL,
    interactor_b_ns TEXT NOT NULL,
    interactor_b_id TEXT NOT NULL,
    interaction_type TEXT,
    confidence_score DOUBLE PRECISION,
    publication_id TEXT,
    source_file TEXT NOT NULL,
    source_row BIGINT NOT NULL,
    parser_version TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT now(),
    UNIQUE (dataset_id, pair_key, publication_id, source_row)
);

CREATE INDEX idx_interactions_pair_key ON interactions(pair_key);
CREATE INDEX idx_interactions_dataset ON interactions(dataset_id);
```

### Example: MITAB row to canonical output

```text
uniprotkb:P12345  uniprotkb:Q99999  -  -  geneA  geneB  psi-mi:"MI:0018"(two hybrid)|psi-mi:"MI:0407"(direct interaction)  Doe et al. (2023)  pubmed:12345678  taxid:9606(human)  taxid:9606(human)  psi-mi:"MI:0915"(physical association)  psi-mi:"MI:0469"(IntAct)  intact:EBI-123456  intact-miscore:0.78
```

```json
{
  "dataset_id": 42,
  "pair_key": "uniprotkb:P12345::uniprotkb:Q99999",
  "interactor_a_ns": "uniprotkb",
  "interactor_a_id": "P12345",
  "interactor_b_ns": "uniprotkb",
  "interactor_b_id": "Q99999",
  "methods": [
    "psi-mi:\"MI:0018\"(two hybrid)",
    "psi-mi:\"MI:0407\"(direct interaction)"
  ],
  "publication_id": "pubmed:12345678",
  "interaction_type": "psi-mi:\"MI:0915\"(physical association)",
  "confidence_score": 0.78,
  "source_row": 1287
}
```

---

## 16. What openPIP 2.0 Looks Like When It Ships

A platform that researchers and curators can actually trust. Imports that tell you what failed and why. A codebase that a new contributor can navigate without a guided tour. Multi-format ingestion that can grow as new data formats emerge. A local development setup that mirrors production and comes up in one command.

That is the goal. The architecture supports it, the PoC validates it, and the timeline delivers it.