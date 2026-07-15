# kirbytag-inlinenote

Plugin Kirby qui ajoute le KirbyTag `(note: ...)` et deux syntaxes Markdown pour insérer des notes inline.

## Syntaxes acceptées

### KirbyTag

```
(note: Texte de la note)
(note : Texte de la note)   ← espace avant : accepté (typographie française)
```

### Syntaxes Markdown (converties avant le rendu)

```
^[Texte de la note]         ← syntaxe Pandoc
[^Texte de la note]         ← syntaxe alternative (non suivie de :)
```

## Rendu HTML

```html
<span class="inline-note">Texte de la note</span>
```

La classe CSS est lue depuis le champ `notes_print` de la page courante. Si le champ est absent ou vide, la classe par défaut `inline-note` est utilisée.

## Prérequis

- Kirby 4+

## Installation

Copier le dossier dans `site/plugins/kirbytag-inlinenote/`.

## Licence

MIT
