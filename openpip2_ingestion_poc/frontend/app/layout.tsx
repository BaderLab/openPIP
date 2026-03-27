import "./globals.css";
import { ReactNode } from "react";
import { QueryProvider } from "../components/query-provider";

export const metadata = {
  title: "openPIP 2.0",
  description: "Protein-protein interaction portal"
};

export default function RootLayout({ children }: { children: ReactNode }) {
  return (
    <html lang="en">
      <body>
        <QueryProvider>
          <main>{children}</main>
        </QueryProvider>
      </body>
    </html>
  );
}
