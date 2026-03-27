"use client";

import { useQuery } from "@tanstack/react-query";
import { getJson } from "./api";

export function AdminSettings() {
  const query = useQuery({
    queryKey: ["admin-settings"],
    queryFn: () => getJson<{ dataset_management: boolean; annotation_management: boolean; auth_provider: string }>("/admin/settings"),
  });

  return (
    <section className="card">
      <h2>Admin Settings</h2>
      <p>Dataset management: {String(query.data?.dataset_management ?? false)}</p>
      <p>Annotation management: {String(query.data?.annotation_management ?? false)}</p>
      <p>Auth provider: {query.data?.auth_provider ?? "unknown"}</p>
    </section>
  );
}
