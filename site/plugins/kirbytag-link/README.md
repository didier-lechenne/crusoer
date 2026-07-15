# kirbytag-link

Plugin Kirby qui corrige la résolution des liens internes générés par le champ markdown-field.

## Problème résolu

Le markdown-field de Fabian Michael génère des liens internes sous la forme `/@/page/UUID` au lieu du protocole natif `page://UUID`. Le tag `(link: ...)` de Kirby 5 ne résout pas ce format, ce qui produit des URL cassées.

## Ce que ça fait

Via le hook `kirbytags:before`, remplace à la volée :

```
(link: /@/page/abc123 ...)  →  (link: page://abc123 ...)
```

Le tag `link` natif de Kirby prend ensuite le relais et résout `page://UUID` en URL réelle.

## Prérequis

- Kirby 5+
- Plugin [fabianmichael/kirby-markdown-field](https://github.com/fabianmichael/kirby-markdown-field)

## Installation

Copier le dossier dans `site/plugins/kirbytag-link/`.

## Licence

MIT
