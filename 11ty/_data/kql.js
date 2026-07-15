// Le slash final est retiré : kirbyUrl est concaténé avec des chemins
// commençant par "/" (/api/query, /media/...), un slash final produirait
// des URLs en "//" que Kirby refuse (404).
export const kirbyUrl = (
  process.env.KIRBY_URL ?? "https://crusoer-11ty.test"
).replace(/\/+$/, "");

const url = `${kirbyUrl}/api/query`;

// Chaque requête identique n'est envoyée qu'une fois par build : les données
// sont demandées à la fois par la cascade _data d'Eleventy et par le hook
// eleventy.before (préchauffage des médias). Le cache est vidé à chaque
// début de build (clearKqlCache) pour que le mode watch voie les
// modifications du contenu.
const cache = new Map();

export function clearKqlCache() {
  cache.clear();
}

export function kql(query) {
  const key = JSON.stringify(query);

  if (!cache.has(key)) {
    const promise = (async () => {
      const res = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(query),
      });
      const data = await res.json();
      return data.result;
    })();
    promise.catch(() => cache.delete(key));
    cache.set(key, promise);
  }

  return cache.get(key);
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
