<?php

use Kirby\Cms\App;

/**
 * markdown-field-extras
 *
 * Regroupe les boutons custom de la barre d'outils du champ Markdown :
 * cite, petites capitales, espaces insécables, exposants/indices,
 * guillemets français, listes. (fusion des anciens micro-plugins
 * markdown-field-cite / -smallcap / -spaces / -exposants-guillemets)
 */
// Note : l'option `fabianmichael.markdown-field.customHighlights` (surlignage
// des notes de bas de page dans l'éditeur) est définie dans site/config/config.php
// — un plugin tiers ne peut pas écrire dans l'espace d'options d'un autre plugin.
App::plugin('dlechenne/markdown-field-extras', []);
