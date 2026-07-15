# kirbytag-imagenote

Plugin Kirby qui ajoute le KirbyTag `(imagenote: ...)` pour afficher une image inline comme une note latérale (sidenote).

## Usage

```
(imagenote: mon-image.jpg)
(imagenote: mon-image.jpg caption: Légende de l'image)
(imagenote: mon-image.jpg caption: Légende class: ma-classe)
```

La valeur peut être un nom de fichier Kirby (résolu via `$page->file()`) ou une URL directe.

## Rendu HTML

Génère un `<span class="imagenote sn-note figure">` avec :

- une image redimensionnée à 400 px avec srcset (`default`)
- un lien `<a data-lightbox="imagenote">` ouvrant l'image en lightbox
- une légende `<span class="figcaption">` si `caption` est fourni ou présent dans les métadonnées du fichier
- un `id` généré depuis le nom du fichier (sans extension, espaces et `_` → `-`)

## Attributs

| Attribut | Description |
|----------|-------------|
| valeur | Nom du fichier image ou URL |
| `caption` | Légende (optionnel — fallback sur le champ `caption` du fichier) |
| `class` | Classe CSS supplémentaire (optionnel) |

## Panel

Enregistre un highlight personnalisé pour le [markdown-field](https://github.com/fabianmichael/kirby-markdown-field) (`cm-footnote-full`) afin de coloriser la syntaxe `(imagenote: ...)` dans l'éditeur.

## Prérequis

- Kirby 4+
- Plugin [fabianmichael/kirby-markdown-field](https://github.com/fabianmichael/kirby-markdown-field) pour le highlight Panel (optionnel)

## Installation

Copier le dossier dans `site/plugins/kirbytag-imagenote/`.

## Licence

MIT
