# Crusoer

Site Crusoer basé sur Kirby CMS + Eleventy (générateur de site statique).

Kirby sert de CMS local (Panel, contenu, médias). Eleventy interroge Kirby via [KQL](https://github.com/getkirby/kql) et génère le site statique dans `/static`, qui est ensuite déployé chez Deuxfleurs. L'instance Kirby ne tourne jamais en production.

## Prérequis

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) ≥ 8.2 et [Composer](https://getcomposer.org/) — fournis par [Herd](https://herd.laravel.com/), qui sert aussi le site en local
- [Node.js](https://nodejs.org/) ≥ 18 (avec npm) — pour le build Eleventy (`/11ty`) et l'outil de déploiement dxfl

## Installation

### Cloner le dépôt avec les submodules

```bash
git clone --recurse-submodules https://codeberg.org/didierlechenne/crusoer.git
cd crusoer
```

### Si le dépôt est déjà cloné

```bash
git submodule update --init --recursive
```

### Dépendances PHP

```bash
composer install
```

### Dépendances du plugin orthotypo

Le plugin [orthotypo](https://codeberg.org/julienbidoret/orthotypo) (submodule) a ses propres dépendances Composer (JoliTypo) à installer dans son dossier :

```bash
cd site/plugins/orthotypo
composer install
cd ../../..
```

### Dépendances Node (Eleventy)

```bash
cd 11ty
npm install
cd ..
```

### Dépendance Node racine : dxfl (déploiement)

À la racine du projet, `npm install` installe [dxfl](https://www.npmjs.com/package/dxfl), l'outil de déploiement vers Deuxfleurs. La commande `deploy` (bouton Panel) l'appelle via `node_modules/.bin/dxfl` — sans cette étape, le déploiement ne fonctionne pas.

```bash
npm install
```

### Contenu (non versionné)

Le dossier `/content` n'est **pas** dans le dépôt (voir `.gitignore`). Il faut le récupérer séparément (sauvegarde, SFTP depuis une installation existante) et le placer à la racine du projet. Sans lui, le site n'a ni pages ni `site.txt`.

## Configuration

1. Configurer le serveur local ([Herd](https://herd.laravel.com/)) pour pointer vers le dossier du projet
2. Créer `site/config/config.{domaine}.php` si nécessaire (debug, cache)
3. Créer `site/config/config.secrets.php` (non versionné) pour le déploiement — il doit retourner un tableau avec les clés S3 Deuxfleurs :
   ```php
   <?php
   return [
     'AWS_ACCESS_KEY_ID'     => '…',
     'AWS_SECRET_ACCESS_KEY' => '…',
   ];
   ```
4. Accéder au Panel : `http://crusoer.test/panel`

## Générer le site statique

L'instance Kirby locale doit **tourner** pendant le build (Eleventy la requête via KQL, et « préchauffe » les fichiers `/media` en les requêtant).

### En phase de développement

```bash
cd 11ty
npm run serve      # http://localhost:8080
```

`npm run serve` sert le site **déjà généré** (lancer `npm run build` d'abord si `/static` est vide) et surveille les templates et `/content` : chaque enregistrement dans le Panel met à jour ce qui a changé dans `/static` (`--ignore-initial --incremental`, ~10-15 s par enregistrement, le temps de réinterroger Kirby) et recharge le navigateur. Équivalent du bouton Panel « 2. Activer la mise à jour automatique » (`php vendor/bin/kirby watch`).

### Build ponctuel

```bash
cd 11ty
npm run build      # génère le site dans /static
```

Équivalent du bouton Panel « Générer le site statique (11ty) » (Site → Configuration). Pour vérifier le résultat tel qu'il sera déployé, utiliser ensuite le bouton « Prévisualiser le site statique » (sert `/static` sans rebuild sur http://localhost:8081).

Notes :

- L'URL de l'instance Kirby se règle avec la variable d'environnement `KIRBY_URL` (défaut : `https://crusoer-11ty.test`, voir `11ty/_data/kql.js`).
- Les scripts npm posent `NODE_TLS_REJECT_UNAUTHORIZED=0` car le certificat local de Herd est auto-signé.
- L'API KQL est ouverte sans authentification (`kql.auth => false` dans `site/config/config.php`) : c'est voulu, uniquement pour le build local — cette instance n'est jamais exposée en production.

## Prévisualiser et déployer

Le site statique est déployé chez [Deuxfleurs](https://deuxfleurs.fr/) (Garage S3) via [dxfl](https://www.npmjs.com/package/dxfl). Avant le premier déploiement :

```bash
npm install    # à la racine du projet : installe dxfl dans node_modules/.bin
```

Les clés S3 sont lues depuis `site/config/config.secrets.php` (voir la config `deuxfleurs` dans `site/config/config.php`).

Depuis le Panel (Site → Configuration) ou en CLI :

```bash
php vendor/bin/kirby preview   # sert ./static tel quel sur http://localhost:8081
php vendor/bin/kirby deploy    # envoie ./static chez Deuxfleurs
```

## Structure

```
/assets         → CSS, JS, images statiques
/content        → Contenu du site (non versionné)
/11ty           → Générateur Eleventy (npm run build)
/kirby          → Kirby CMS (submodule Git)
/media          → Fichiers générés par Kirby (cache images, non versionné)
/static         → Site statique généré (non versionné)
/site
  /blueprints   → Définitions des pages et champs
  /config       → Configuration Kirby
  /plugins      → Plugins Kirby
  /snippets     → Composants réutilisables
  /templates    → Templates des pages
```

## Plugins

### Git submodules (`git submodule update --init --recursive`)

| Dossier | Dépôt |
|---|---|
| `kirby` | [getkirby/kirby](https://github.com/getkirby/kirby) |
| `site/plugins/orthotypo` | [julienbidoret/orthotypo](https://codeberg.org/julienbidoret/orthotypo) *(puis `composer install` dans le dossier du plugin)* |
### Composer (`composer install`)

| Paquet | Usage |
|---|---|
| [getkirby/cli](https://github.com/getkirby/cli) | CLI Kirby (`vendor/bin/kirby`) |
| [bnomei/kirby-janitor](https://github.com/bnomei/kirby-janitor) | Tâches planifiées / boutons panel (installé dans `site/plugins/kirby-janitor`) |
| [getkirby/kql](https://github.com/getkirby/kql) | Query language, utilisé par le build 11ty (installé dans `site/plugins/kql`) |

### Plugins locaux (versionnés dans ce dépôt)

- `kirby-audio-block`, `pdf-block` — blocs personnalisés
- `kirby-video-embed-block` — intégration vidéo
- `kirby-link-color` — couleur des liens
- `kirby-markdown-field-extras` — extensions du champ markdown
- `kirby-pdf-inline-preview` — aperçu PDF inline
- `kirbytag-imagenote`, `kirbytag-inlinenote`, `kirbytag-link`, `kirbytag-pdfnote` — kirby tags
- `static-site-generator` — génération du site statique (voir `site/commands/generate-static.php`)
- `crusoer-panel` — méthodes utilitaires du Panel (couleur du bouton « mise à jour automatique » selon l'état du serveur)
- `markdown-field`, `hidden-characters`, `kirby-column-blocks`, `reload-on-save`, `staticache`, `typo-and-paste`, `kirby-hyphenate` — anciennement sous-modules, réintégrés comme fichiers versionnés normaux (les copies locales sont figées à une version antérieure à l'upstream actuel ; mettre à jour manuellement si besoin)

Le flux RSS (`/feed.xml`) est généré par une route custom dans `site/config/config.php` (plus de plugin feed).

## Mettre à jour Kirby

Depuis le Panel (Site → Configuration, bouton « Mettre à jour Kirby ») ou en CLI :

```bash
php vendor/bin/kirby update-kirby
```

La commande récupère la dernière version publiée de la même version majeure et la déploie dans `kirby/` (`git fetch` + `git checkout` du tag). Pour choisir une version précise, manuellement :

```bash
cd kirby
git fetch --depth 1 origin tag 5.x.y   # remplacer par la version voulue
git checkout 5.x.y
cd ..
```

Dans les deux cas, penser à enregistrer la nouvelle version du submodule :

```bash
git add kirby
git commit -m "Update Kirby vers 5.x.y"
```
