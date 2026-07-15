# kirbytag-pdfnote

Plugin Kirby qui ajoute le KirbyTag `(pdfnote: ...)` pour afficher un PDF inline comme une note latérale (sidenote).

## Usage

```
(pdfnote: mon-document.pdf)
(pdfnote: mon-document.pdf caption: Titre du document)
```

La valeur peut être un nom de fichier Kirby (résolu via `$page->file()`) ou une URL directe.

## Rendu HTML

Génère un `<span class="pdfnote sn-note figure">` avec :

- un lien `<a data-lightbox="pdf">` ouvrant le PDF dans la lightbox
- si le fichier a un champ `cover` renseigné : une image miniature (redimensionnée à 400 px)
- sinon : une icône SVG + le nom du fichier
- une légende `<span class="figcaption">` si `caption` est fourni ou présent dans les métadonnées du fichier

L'attribut `id` est généré depuis le nom du fichier (sans extension, espaces et `_` → `-`).

## Attributs

| Attribut | Description |
|----------|-------------|
| valeur | Nom du fichier PDF ou URL |
| `caption` | Légende (optionnel — fallback sur le champ `caption` du fichier) |

## Panel

Enregistre un highlight personnalisé pour le [markdown-field](https://github.com/fabianmichael/kirby-markdown-field) (`cm-footnote-full`) afin de coloriser la syntaxe `(pdfnote: ...)` dans l'éditeur.

## Prérequis

- Kirby 4+
- Plugin [fabianmichael/kirby-markdown-field](https://github.com/fabianmichael/kirby-markdown-field) pour le highlight Panel (optionnel)

## Installation

Copier le dossier dans `site/plugins/kirbytag-pdfnote/`.

## Licence

MIT
