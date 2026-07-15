# Crusoer — build Eleventy

Sous-projet [Eleventy](https://www.11ty.dev/) qui génère le site statique de Crusoer dans `../static`, à partir du contenu de l'instance Kirby locale interrogée via [KQL](https://github.com/getkirby/kql).

Basé à l'origine sur l'[Eleventykit](https://github.com/getkirby/eleventykit) de Kirby (© Bastian Allgeier, MIT — voir `LICENSE.md`).

## Utilisation

L'instance Kirby locale doit tourner (Herd) pendant le build.

```bash
npm install
npm run build      # génère ../static
npm run serve      # build + serveur local sur http://localhost:8080
npm run watch      # rebuild à chaque modification (surveille aussi ../content)
```

L'URL de l'instance Kirby se règle avec `KIRBY_URL` (défaut : `https://crusoer-11ty.test`, voir `_data/kql.js`).

## Fonctionnement

- `_data/*.js` — requêtes KQL (publications, about, mentions légales, données du site)
- `_includes/` — layout de base et partiels (metas, excerpt)
- `*.njk`, `publications/` — templates des pages (miroir des templates PHP de `../site/templates`)
- `feed.11ty.js` — recopie le flux Atom généré par la route Kirby `/feed.xml`
- `.eleventy.js` — copie `../assets` et `../media` dans `../static`, « préchauffe » les fichiers médias auprès de Kirby avant la copie, et réécrit les URLs absolues de l'instance locale en URLs relatives
