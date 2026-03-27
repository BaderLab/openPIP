"use client";

import { FormEvent, useMemo, useState } from "react";
import { API_BASE } from "./api";
import { ErrorTable } from "./error-table";

type Job = {
  id: string;
  stage: string;
  status: string;
  processed_rows: number;
  inserted_rows: number;
  skipped_rows: number;
  failed_rows: number;
};

function isUuidLike(value: unknown): value is string {
  return typeof value === "string" && /^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i.test(value);
}

export function UploadManager() {
  const [datasetId, setDatasetId] = useState("42");
  const [parserHint, setParserHint] = useState("psi_mitab");
  const [jobId, setJobId] = useState<string | null>(null);
  const [job, setJob] = useState<Job | null>(null);
  const [busy, setBusy] = useState(false);

  const progress = useMemo(() => {
    if (!job) return 0;
    const total = job.processed_rows || 1;
    const done = job.inserted_rows + job.failed_rows + job.skipped_rows;
    return Math.min(100, Math.round((done / total) * 100));
  }, [job]);

  async function onUpload(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    const input = (e.currentTarget.elements.namedItem("file") as HTMLInputElement);
    const file = input.files?.[0];
    if (!file) return;

    setBusy(true);
    const fd = new FormData();
    fd.append("file", file);
    fd.append("dataset_id", datasetId);
    fd.append("parser_hint", parserHint);

    const res = await fetch(`${API_BASE}/uploads/jobs`, { method: "POST", body: fd });
    const payload = await res.json().catch(() => ({}));
    if (!res.ok || !isUuidLike(payload?.job_id)) {
      setBusy(false);
      return;
    }

    setJobId(payload.job_id);
    const es = new EventSource(`${API_BASE}/uploads/jobs/${payload.job_id}/events`);
    es.addEventListener("progress", (ev) => {
      const data = JSON.parse((ev as MessageEvent).data);
      setJob(data);
    });
    es.addEventListener("done", () => {
      es.close();
      setBusy(false);
    });
    es.onerror = () => {
      es.close();
      setBusy(false);
    };
  }

  async function commitJob() {
    if (!jobId) return;
    setBusy(true);
    const commitRes = await fetch(`${API_BASE}/uploads/jobs/${jobId}/commit`, { method: "POST" });
    if (!commitRes.ok) {
      setBusy(false);
      return;
    }
    const es = new EventSource(`${API_BASE}/uploads/jobs/${jobId}/events`);
    es.addEventListener("progress", (ev) => {
      const data = JSON.parse((ev as MessageEvent).data);
      setJob(data);
    });
    es.addEventListener("done", () => {
      es.close();
      setBusy(false);
    });
    es.onerror = () => {
      es.close();
      setBusy(false);
    };
  }

  return (
    <section className="card">
      <h2>Upload Manager</h2>
      <form onSubmit={onUpload} className="grid">
        <input name="file" type="file" required />
        <input value={datasetId} onChange={(e) => setDatasetId(e.target.value)} placeholder="Dataset ID" />
        <select value={parserHint} onChange={(e) => setParserHint(e.target.value)}>
          <option value="psi_mitab">PSI-MI TAB</option>
          <option value="csv">CSV</option>
        </select>
        <button disabled={busy} type="submit">Start Validation</button>
      </form>

      {jobId && <p>Job: {jobId}</p>}
      {job && (
        <>
          <div className="badge">{job.stage} / {job.status}</div>
          <div className="progress"><span style={{ width: `${progress}%` }} /></div>
          <p>Processed: {job.processed_rows} Inserted: {job.inserted_rows} Skipped: {job.skipped_rows} Failed: {job.failed_rows}</p>
          {job.status === "validated" && <button onClick={commitJob} disabled={busy}>Commit Valid Rows</button>}
        </>
      )}
      {jobId && <ErrorTable jobId={jobId} />}
    </section>
  );
}
