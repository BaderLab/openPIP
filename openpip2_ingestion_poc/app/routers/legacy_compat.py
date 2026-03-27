from pathlib import Path

from fastapi import APIRouter, File, Form, HTTPException, Query, Request, UploadFile
from fastapi.responses import StreamingResponse

from ..db import (
    create_job,
    create_upload_file,
    ensure_dataset,
    export_interactions_csv,
    export_interactions_mitab,
    get_job,
    search_interactions,
)
from ..jobs import commit_upload_job, validate_upload_job

router = APIRouter(tags=["legacy-compat"])


def _tokens(search_term: str) -> list[str]:
    return [t.strip() for t in search_term.split(",") if t.strip()]


@router.get("/admin/media/upload")
async def legacy_show_upload() -> dict:
    return {"template": "admin/media/upload", "ok": True}


@router.post("/admin/media/upload/process/{dir_name}")
async def legacy_upload_process(
    request: Request,
    dir_name: str,
    files: list[UploadFile] = File(...),
    dataset_id: int = Form(42),
    parser_hint: str = Form("psi_mitab"),
):
    await ensure_dataset(request.app.state.db_pool, dataset_id)

    outputs = []
    for uploaded in files:
        safe_name = Path(uploaded.filename or "upload.dat").name
        storage_key = f"{dir_name}/{safe_name}"
        storage_path = request.app.state.storage_root / storage_key
        storage_path.parent.mkdir(parents=True, exist_ok=True)
        storage_path.write_bytes(await uploaded.read())

        upload_file_id = await create_upload_file(
            pool=request.app.state.db_pool,
            dataset_id=dataset_id,
            filename=safe_name,
            storage_key=storage_key,
            parser_hint=parser_hint,
        )
        job_id = await create_job(
            pool=request.app.state.db_pool,
            upload_file_id=upload_file_id,
            dataset_id=dataset_id,
            storage_key=storage_key,
            parser_hint=parser_hint,
        )
        queue_job_id = None
        if request.app.state.redis is None:
            ctx = {"db_pool": request.app.state.db_pool, "storage_root": str(request.app.state.storage_root)}
            result = await validate_upload_job(ctx, job_id, dataset_id, storage_key, parser_hint)
            queue_job_id = f"sync-{result['job_id']}"
        else:
            queue_job = await request.app.state.redis.enqueue_job(
                "validate_upload_job",
                job_id,
                dataset_id,
                storage_key,
                parser_hint,
            )
            queue_job_id = queue_job.job_id if queue_job else None
        outputs.append(
            {
                "uploaded": True,
                "fileName": safe_name,
                "job_id": job_id,
                "queue_job_id": queue_job_id,
            }
        )

    if len(outputs) == 1:
        return outputs[0]
    return {"uploaded": True, "items": outputs}


@router.get("/admin/data_manager/{folder}/{file}")
async def legacy_get_lines(request: Request, folder: str, file: str):
    path = request.app.state.storage_root / folder / file
    if not path.exists():
        raise HTTPException(status_code=404, detail="file not found")

    linecount = 0
    proteins: set[str] = set()
    with path.open("r", encoding="utf-8", errors="replace") as handle:
        for line in handle:
            linecount += 1
            parts = line.rstrip("\n").split("\t")
            if len(parts) >= 2:
                proteins.add(parts[0])
                proteins.add(parts[1])

    return {"proteincount": len(proteins), "linecount": linecount}


@router.post("/admin/data_manager/insert_data/{folder}/{file}")
async def legacy_insert_data(
    request: Request,
    folder: str,
    file: str,
    dataset_id: int = Query(42),
    parser_hint: str = Query("psi_mitab"),
):
    storage_key = f"{folder}/{file}"
    path = request.app.state.storage_root / storage_key
    if not path.exists():
        raise HTTPException(status_code=404, detail="file not found")

    await ensure_dataset(request.app.state.db_pool, dataset_id)
    upload_file_id = await create_upload_file(
        pool=request.app.state.db_pool,
        dataset_id=dataset_id,
        filename=file,
        storage_key=storage_key,
        parser_hint=parser_hint,
    )
    job_id = await create_job(
        pool=request.app.state.db_pool,
        upload_file_id=upload_file_id,
        dataset_id=dataset_id,
        storage_key=storage_key,
        parser_hint=parser_hint,
    )

    ctx = {"db_pool": request.app.state.db_pool, "storage_root": str(request.app.state.storage_root)}
    await validate_upload_job(ctx, job_id, dataset_id, storage_key, parser_hint)
    await commit_upload_job(ctx, job_id, dataset_id, storage_key, parser_hint)
    job = await get_job(request.app.state.db_pool, job_id)
    return {"status": "success followed", "job": job}


@router.get("/download/interaction_csv/{search_term}")
async def legacy_download_interaction_csv(request: Request, search_term: str):
    tokens = _tokens(search_term)
    dataset_id = None
    if not tokens:
        tokens = [""]

    async def gen():
        yield "ID(s) interactor A,ID(s) interactor B,Alias(es) interactor A,Alias(es) interactor B\n"
        seen: set[str] = set()
        for token in tokens:
            rows = await search_interactions(
                request.app.state.db_pool,
                query=token,
                dataset_id=dataset_id,
                limit=5000,
                offset=0,
            )
            for r in rows:
                line = (
                    f"{r['interactor_a_ns']}:{r['interactor_a_id']},"
                    f"{r['interactor_b_ns']}:{r['interactor_b_id']},"
                    f"{r['interactor_a_id']},{r['interactor_b_id']}\n"
                )
                if line not in seen:
                    seen.add(line)
                    yield line

    return StreamingResponse(
        gen(),
        media_type="text/csv",
        headers={"Content-Disposition": "attachment; filename=interactions_csv.csv"},
    )


@router.get("/download/interactor_csv/{search_term}")
async def legacy_download_interactor_csv(request: Request, search_term: str):
    tokens = _tokens(search_term)
    if not tokens:
        tokens = [""]

    async def gen():
        yield "interactor\n"
        seen: set[str] = set()
        for token in tokens:
            rows = await search_interactions(
                request.app.state.db_pool,
                query=token,
                dataset_id=None,
                limit=5000,
                offset=0,
            )
            for r in rows:
                for val in (r["interactor_a_id"], r["interactor_b_id"]):
                    if val not in seen:
                        seen.add(val)
                        yield f"{val}\n"

    return StreamingResponse(
        gen(),
        media_type="text/csv",
        headers={"Content-Disposition": "attachment; filename=interactor_csv.csv"},
    )


@router.get("/download/psi_mitab/{search_term}")
async def legacy_download_psi_mitab(request: Request, search_term: str):
    tokens = _tokens(search_term)
    if not tokens:
        tokens = [""]

    header = (
        "ID(s) interactor A\tID(s) interactor B\tAlt. ID(s) interactor A\tAlt. ID(s)interactor B\t"
        "Alias(es) interactor A\tAlias(es) interactor B\tInteraction detection method(s)\t"
        "Publication 1st author(s)\tPublication Identifier(s)\tTaxid interactor A\tTaxid interactor B\t"
        "Interaction type(s)\tSource database(s)\tInteraction identifier(s)\tConfidence value(s)\n"
    )

    async def gen():
        yield header
        seen: set[str] = set()
        for token in tokens:
            rows = await search_interactions(
                request.app.state.db_pool,
                query=token,
                dataset_id=None,
                limit=5000,
                offset=0,
            )
            for r in rows:
                conf = f"intact-miscore:{r['confidence_score']}" if r["confidence_score"] is not None else "-"
                line = (
                    f"{r['interactor_a_ns']}:{r['interactor_a_id']}\t"
                    f"{r['interactor_b_ns']}:{r['interactor_b_id']}\t-\t-\t"
                    f"{r['interactor_a_id']}\t{r['interactor_b_id']}\t"
                    "psi-mi:MI:0000(unspecified method)\t-\t"
                    f"{r['publication_id'] or '-'}\ttaxid:-\ttaxid:-\t"
                    f"{r['interaction_type'] or '-'}\tpsi-mi:MI:0469(IntAct)\t-\t{conf}\n"
                )
                if line not in seen:
                    seen.add(line)
                    yield line

    return StreamingResponse(
        gen(),
        media_type="text/plain",
        headers={"Content-Disposition": "attachment; filename=psi_mitab.tab"},
    )


@router.get("/search/{search_term}")
@router.get("/search_results/{search_term}")
@router.get("/admin/search/{search_term}")
async def legacy_search_results(request: Request, search_term: str):
    terms = [] if search_term == "no_search" else _tokens(search_term)
    interactions = []
    nodes: dict[str, dict] = {}

    for term in terms:
        rows = await search_interactions(
            request.app.state.db_pool,
            query=term,
            dataset_id=None,
            limit=5000,
            offset=0,
        )
        for r in rows:
            a_id = r["interactor_a_id"]
            b_id = r["interactor_b_id"]
            nodes[a_id] = {"id": a_id, "label": a_id}
            nodes[b_id] = {"id": b_id, "label": b_id}
            interactions.append(
                {
                    "id": r["id"],
                    "source": a_id,
                    "target": b_id,
                    "interaction_type": r["interaction_type"],
                    "confidence": r["confidence_score"],
                }
            )

    return {
        "all_proteins": list(nodes.values()),
        "all_interactions": interactions,
        "domains": "",
        "complexes": "",
        "query_protein_id_array": terms,
        "search_term": search_term,
        "unfound_protein_summary": "",
        "found_protein_summary": ",".join(terms),
    }


@router.api_route("/search_results_interactions", methods=["GET", "POST"])
async def legacy_search_results_interactions(request: Request):
    params = request.query_params
    search_term = params.get("search_term_parameter", "no_search")
    return await legacy_search_results(request, search_term)