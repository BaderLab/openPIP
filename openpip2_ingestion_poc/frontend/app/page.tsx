import { AdminSettings } from "../components/admin-settings";
import { DatasetBrowser } from "../components/dataset-browser";
import { NetworkView } from "../components/network-view";
import { UploadManager } from "../components/upload-manager";

export default function Page() {
  return (
    <div className="dashboard-shell">
      <header className="top-brand">
        <div className="brand-mark">openPIP</div>
        <div className="brand-title">The Open-source Protein Interaction Platform</div>
        <div className="auth-links">
          <a href="#">Register</a>
          <a href="#">Login</a>
        </div>
      </header>

      <nav className="main-tabs">
        <a className="active" href="#">Home</a>
        <a href="#">Search</a>
        <a href="#">Downloads</a>
        <a href="#">About</a>
        <a href="#">FAQ</a>
        <a href="#">Contact</a>
      </nav>

      <section className="workspace card">
        <div className="toolbar-row">
          <a href="#">Search</a>
          <a href="#">Filter</a>
          <a href="#">Layout</a>
          <a href="#">Downloads</a>
          <a href="#">External Links</a>
          <div className="spacer" />
          <a href="#">Summary</a>
          <a href="#">Legend</a>
        </div>
        <NetworkView />
      </section>

      <section className="lower-grid">
        <UploadManager />
        <DatasetBrowser />
        <AdminSettings />
      </section>
    </div>
  );
}
