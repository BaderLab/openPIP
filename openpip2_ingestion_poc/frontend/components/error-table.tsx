"use client";

import { useQuery } from "@tanstack/react-query";
import { API_BASE, getJson } from "./api";

type ErrorRow = {
  id: number;
  source_row: number;
  error_code: string;
  error_message: string;
  remediation_hint: string;
};

export function ErrorTable({ jobId }: { jobId: string }) {
  const query = useQuery({
    queryKey: ["errors", jobId],
    queryFn: () => getJson<{ items: ErrorRow[]; count: number }>(`/uploads/jobs/${jobId}/errors`),
    enabled: !!jobId,
    refetchInterval: 3000,
  });

  if (!jobId) return null;
  if (query.isLoading) return <section className="card">Loading errors...</section>;
  if (!query.data) return null;

  return (
    <section className="card">
      <h2>Error Table</h2>
      <a href={`${API_BASE}/uploads/jobs/${jobId}/errors/export`}>Download CSV</a>
      <table>
        <thead>
          <tr>
            <th>Row</th>
            <th>Code</th>
            <th>Message</th>
            <th>Remediation</th>
          </tr>
        </thead>
        <tbody>
          {query.data.items.map((e) => (
            <tr key={e.id}>
              <td>{e.source_row}</td>
              <td>{e.error_code}</td>
              <td>{e.error_message}</td>
              <td>{e.remediation_hint}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </section>
  );
}
