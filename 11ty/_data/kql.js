export const kirbyUrl = process.env.KIRBY_URL ?? "https://crusoer-11ty.test";

const url = `${kirbyUrl}/api/query`;

export async function kql(query) {
  const res = await fetch(url, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(query),
  });
  const data = await res.json();
  return data.result;
}

// Kirby génère les fichiers média physiquement à la première requête HTTP
// reçue sur leur URL. Comme les données KQL ne font que calculer ces URLs
// sans jamais les requêter, on force ici cette génération avant que
// addPassthroughCopy ne copie le dossier /media du disque.
export async function warmMedia(html) {
  const urls = new Set();
  const re = /\/media\/[^"'\s)]+/g;
  let match;
  while ((match = re.exec(html))) {
    urls.add(match[0]);
  }

  await Promise.all(
    [...urls].map(async (path) => {
      try {
        await fetch(`${kirbyUrl}${path}`, { redirect: "follow" });
      } catch {
        // best-effort : un média qui échoue au préchauffage ne doit pas
        // bloquer le build, il sera juste absent de la copie statique.
      }
    }),
  );
}
