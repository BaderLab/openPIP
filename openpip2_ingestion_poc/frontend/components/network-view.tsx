"use client";

import cytoscape from "cytoscape";
import coseBilkent from "cytoscape-cose-bilkent";
import { useEffect, useRef, useState } from "react";

cytoscape.use(coseBilkent);

export function NetworkView() {
  const ref = useRef<HTMLDivElement | null>(null);
  const cyRef = useRef<cytoscape.Core | null>(null);
  const liveTickerRef = useRef<number | null>(null);
  const [selected, setSelected] = useState<string>("BAD");
  const [degree, setDegree] = useState<number>(0);
  const [zoomValue, setZoomValue] = useState<number>(100);
  const [searchNode, setSearchNode] = useState<string>("");
  const [layoutName, setLayoutName] = useState<string>("cose-bilkent");
  const [showLabels, setShowLabels] = useState<boolean>(true);
  const [liveMode, setLiveMode] = useState<boolean>(false);

  useEffect(() => {
    if (!ref.current) return;

    const nodes = [
      "BAD",
      "ACTN2",
      "KRT31",
      "YWHAE",
      "YWHAH",
      "BCL2L2",
      "RAF1",
      "YWHAQ",
      "AKT1",
      "YWHAZ",
      "YWHAB",
      "BCL2L1",
      "BCL2",
      "SFN",
      "EWSR1",
      "S100A10",
      "BCL2L2-PABPN1",
    ].map((id) => ({ data: { id, label: id }, classes: id === "BAD" ? "query" : "interactor" }));

    const edges = [
      { source: "BAD", target: "ACTN2", cls: "verified" },
      { source: "BAD", target: "KRT31", cls: "verified" },
      { source: "BAD", target: "YWHAE", cls: "published" },
      { source: "BAD", target: "YWHAH", cls: "published" },
      { source: "BAD", target: "BCL2L2", cls: "literature" },
      { source: "BAD", target: "RAF1", cls: "published" },
      { source: "BAD", target: "YWHAQ", cls: "published" },
      { source: "BAD", target: "AKT1", cls: "published" },
      { source: "BAD", target: "YWHAZ", cls: "published" },
      { source: "BAD", target: "YWHAB", cls: "published" },
      { source: "BAD", target: "BCL2L1", cls: "literature" },
      { source: "BAD", target: "BCL2", cls: "published" },
      { source: "BAD", target: "SFN", cls: "literature" },
      { source: "BAD", target: "EWSR1", cls: "validated" },
      { source: "BAD", target: "S100A10", cls: "published" },
      { source: "BAD", target: "BCL2L2-PABPN1", cls: "published" },
    ].map((e, idx) => ({ data: { id: `e${idx}`, source: e.source, target: e.target }, classes: e.cls }));

    const cy = cytoscape({
      container: ref.current,
      elements: [...nodes, ...edges],
      style: [
        {
          selector: "node",
          style: {
            "background-color": "#3f7ed3",
            width: 24,
            height: 24,
            label: "data(label)",
            color: "#1f2a35",
            "font-size": 8,
            "font-weight": 600,
            "text-wrap": "none",
            "text-max-width": 64,
            "text-halign": "center",
            "text-valign": "center",
            "text-outline-width": 1.2,
            "text-outline-color": "#f7f7f8",
            "min-zoomed-font-size": 6,
          },
        },
        {
          selector: "node.query",
          style: {
            "background-color": "#d91515",
            width: 38,
            height: 38,
            color: "#111",
            "font-size": 10,
            "text-outline-color": "#f9dddd",
          },
        },
        {
          selector: "node.hidden-label",
          style: {
            label: "",
          },
        },
        {
          selector: "edge",
          style: {
            width: 2,
            "line-color": "#5e9ed3",
            "curve-style": "bezier",
            opacity: 0.72,
          },
        },
        { selector: "edge.published", style: { "line-color": "#5b9ecf" } },
        { selector: "edge.validated", style: { "line-color": "#a77db1", width: 2.5 } },
        { selector: "edge.verified", style: { "line-color": "#915f9d", width: 3 } },
        { selector: "edge.literature", style: { "line-color": "#ef57d7", width: 4 } },
        {
          selector: ".dimmed",
          style: {
            opacity: 0.16,
          },
        },
        {
          selector: ".focus",
          style: {
            opacity: 1,
          },
        },
      ],
      layout: {
        name: "cose-bilkent",
        animate: false,
        fit: true,
        padding: 36,
        randomize: true,
        nodeRepulsion: 12500,
        idealEdgeLength: 92,
        edgeElasticity: 0.38,
        gravity: 0.22,
        nodeDimensionsIncludeLabels: true,
      },
      minZoom: 0.35,
      maxZoom: 2.2,
      wheelSensitivity: 0.18,
    });

    cyRef.current = cy;
    setZoomValue(Math.round(cy.zoom() * 100));
    const central = cy.getElementById("BAD");
    setDegree(central.connectedEdges().length);

    cy.on("tap", "node", (ev) => {
      const node = ev.target;
      setSelected(node.data("label"));
      setDegree(node.connectedEdges().length);

      cy.elements().removeClass("focus").addClass("dimmed");
      const neighborhood = node.closedNeighborhood();
      neighborhood.removeClass("dimmed").addClass("focus");

      // Add a quick pulse so selected nodes feel responsive.
      node
        .animate({ style: { width: node.hasClass("query") ? 42 : 28, height: node.hasClass("query") ? 42 : 28 } }, { duration: 140 })
        .animate({ style: { width: node.hasClass("query") ? 38 : 24, height: node.hasClass("query") ? 38 : 24 } }, { duration: 180 });
    });

    cy.on("mouseover", "node", (ev) => {
      const node = ev.target;
      const nhood = node.closedNeighborhood();
      cy.elements().addClass("dimmed");
      nhood.removeClass("dimmed").addClass("focus");
    });

    cy.on("mouseout", "node", () => {
      cy.elements().removeClass("dimmed focus");
    });

    cy.on("dragfree", "node", () => {
      // Re-run a short, local-ish physics settle to avoid overlaps after manual dragging.
      cy.layout({
        name: "cose-bilkent",
        fit: false,
        animate: true,
        animationDuration: 350,
        randomize: false,
        nodeRepulsion: 13000,
        idealEdgeLength: 90,
        nodeDimensionsIncludeLabels: true,
      }).run();
    });

    cy.on("zoom", () => {
      setZoomValue(Math.round(cy.zoom() * 100));
    });

    return () => {
      if (liveTickerRef.current !== null) {
        window.clearInterval(liveTickerRef.current);
        liveTickerRef.current = null;
      }
      cyRef.current = null;
      cy.destroy();
    };
  }, []);

  useEffect(() => {
    const cy = cyRef.current;
    if (!cy) return;

    if (liveTickerRef.current !== null) {
      window.clearInterval(liveTickerRef.current);
      liveTickerRef.current = null;
    }

    if (!liveMode) return;

    // Gentle periodic settle keeps the graph feeling active instead of static.
    liveTickerRef.current = window.setInterval(() => {
      if (!cyRef.current) return;
      cyRef.current.layout({
        name: layoutName as any,
        fit: false,
        animate: true,
        animationDuration: 450,
        randomize: false,
        nodeRepulsion: 12000,
        idealEdgeLength: 88,
        nodeDimensionsIncludeLabels: true,
      }).run();
    }, 5000);

    return () => {
      if (liveTickerRef.current !== null) {
        window.clearInterval(liveTickerRef.current);
        liveTickerRef.current = null;
      }
    };
  }, [liveMode, layoutName]);

  function zoomIn() {
    if (!cyRef.current) return;
    cyRef.current.zoom({ level: Math.min(cyRef.current.zoom() * 1.15, cyRef.current.maxZoom()), renderedPosition: { x: 300, y: 260 } });
  }

  function zoomOut() {
    if (!cyRef.current) return;
    cyRef.current.zoom({ level: Math.max(cyRef.current.zoom() / 1.15, cyRef.current.minZoom()), renderedPosition: { x: 300, y: 260 } });
  }

  function fitGraph() {
    if (!cyRef.current) return;
    cyRef.current.elements().removeClass("dimmed focus");
    cyRef.current.fit(undefined, 36);
  }

  function runLayout(name: string) {
    if (!cyRef.current) return;
    setLayoutName(name);
    cyRef.current.layout({
      name: name as any,
      animate: true,
      animationDuration: 650,
      fit: true,
      padding: 36,
      randomize: true,
      nodeDimensionsIncludeLabels: true,
    }).run();
  }

  function focusNodeById() {
    if (!cyRef.current) return;
    const id = searchNode.trim();
    if (!id) return;
    const node = cyRef.current.$id(id);
    if (!node || node.empty()) return;

    setSelected(node.data("label"));
    setDegree(node.connectedEdges().length);

    cyRef.current.elements().removeClass("focus").addClass("dimmed");
    const neighborhood = node.closedNeighborhood();
    neighborhood.removeClass("dimmed").addClass("focus");
    cyRef.current.animate({
      center: { eles: node },
      zoom: Math.max(cyRef.current.zoom(), 1.2),
      duration: 260,
    });
  }

  function toggleLabels() {
    if (!cyRef.current) return;
    const next = !showLabels;
    setShowLabels(next);
    if (next) {
      cyRef.current.nodes().removeClass("hidden-label");
    } else {
      cyRef.current.nodes().addClass("hidden-label");
    }
  }

  return (
    <div className="network-shell">
      <div className="network-controls">
        <button className="zoom-btn" onClick={fitGraph} title="Fit">
          o
        </button>
        <button className="zoom-btn" onClick={zoomIn} title="Zoom in">
          +
        </button>
        <input
          className="zoom-track"
          type="range"
          min={35}
          max={220}
          value={zoomValue}
          onChange={(e) => {
            const value = Number(e.target.value);
            setZoomValue(value);
            if (cyRef.current) {
              cyRef.current.zoom(value / 100);
            }
          }}
        />
        <button className="zoom-btn" onClick={zoomOut} title="Zoom out">
          -
        </button>
      </div>

      <div ref={ref} className="network-canvas" />

      <aside className="network-sidebar">
        <h3>Controls</h3>
        <div className="control-stack">
          <input
            value={searchNode}
            onChange={(e) => setSearchNode(e.target.value)}
            placeholder="Find node (e.g., BAD)"
            className="compact-input"
          />
          <button className="compact-btn" onClick={focusNodeById}>Focus Node</button>
          <div className="layout-row">
            <button className={`compact-btn ${layoutName === "cose-bilkent" ? "active" : ""}`} onClick={() => runLayout("cose-bilkent")}>CoSE</button>
            <button className={`compact-btn ${layoutName === "concentric" ? "active" : ""}`} onClick={() => runLayout("concentric")}>Concentric</button>
            <button className={`compact-btn ${layoutName === "circle" ? "active" : ""}`} onClick={() => runLayout("circle")}>Circle</button>
          </div>
          <button className={`compact-btn ${liveMode ? "active" : ""}`} onClick={() => setLiveMode((v) => !v)}>
            {liveMode ? "Live physics: ON" : "Live physics: OFF"}
          </button>
          <button className="compact-btn" onClick={toggleLabels}>{showLabels ? "Hide labels" : "Show labels"}</button>
        </div>

        <h3>Summary</h3>
        <p>
          Selected node: <strong>{selected}</strong>
        </p>
        <p>Connected edges: {degree}</p>
        <p>Zoom: {zoomValue}%</p>
        <h3 style={{ marginTop: 14 }}>Legend</h3>
        <ul className="legend-list">
          <li>Blue edges: published</li>
          <li>Purple edges: verified or validated</li>
          <li>Pink edges: literature</li>
          <li>Red node: query seed</li>
        </ul>
      </aside>
    </div>
  );
}
