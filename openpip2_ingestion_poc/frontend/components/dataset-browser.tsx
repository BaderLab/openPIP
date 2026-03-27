"use client";

import { useQuery } from "@tanstack/react-query";
import { getJson } from "./api";

type Dataset = {
  id: number;
  name: string;
  description: string | null;
  interaction_count: number;
};

export function DatasetBrowser() {
  const query = useQuery({
    queryKey: ["datasets"],
    queryFn: () => getJson<{ items: Dataset[]; count: number }>("/datasets"),
  });

  if (query.isLoading) return <section className="card">Loading datasets...</section>;

  return (
    <section className="card">
      <h2>Dataset Browser</h2>
      <table>
        <thead>
          <tr><th>ID</th><th>Name</th><th>Interactions</th></tr>
        </thead>
        <tbody>
          {(query.data?.items ?? []).map((d) => (
            <tr key={d.id}>
              <td>{d.id}</td>
              <td>{d.name}</td>
              <td>{d.interaction_count}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </section>
  );
}
