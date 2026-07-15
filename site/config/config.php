<?php


// Secrets non versionnés (clés S3 Deuxfleurs, etc.) — voir config.secrets.php
$secrets = file_exists(__DIR__ . '/config.secrets.php')
    ? require __DIR__ . '/config.secrets.php'
    : [];

return [

 "url" => false,
  'debug' => true,

  'cache' => [
    'pages' => [
      'active' => true,
    ],
  ],

  // Déploiement du site statique vers Deuxfleurs (Garage) via dxfl.
  // Les clés S3 (keyId / keySecret) sont lues depuis config.secrets.php
  // (non versionné). dxfl est appelé via node_modules/.bin/dxfl.
  'deuxfleurs' => [
    'websiteId' => 'www.crusoer.fr',   // nom exact du site (cf. `dxfl list`)
    'keyId'     => $secrets['AWS_ACCESS_KEY_ID']     ?? null,
    'keySecret' => $secrets['AWS_SECRET_ACCESS_KEY'] ?? null,
  ],

  'locale'       => 'fr_FR.utf8',
  'date.handler' => 'date',
  'date.timezone' => 'Europe/Paris',


  'panel' => [
    'css' => 'assets/css/panel.css',
    'js'  => 'assets/js/panel.js',
    'viewButtons' => [
      'page' => [
        'typo-and-paste',
        'open',
        'preview', 'settings', 'languages', 'status',
      ],
      'site' => [
        'typo-and-paste',
        'open',
        'preview', 'languages',
      ],
    ],
  ],

  'accentgrave.orthotypo.enabled'      => true,
  'medienbaecker.hyphenate.language'   => 'fr',
  'medienbaecker.hyphenate.minWordLength' => 7,

  'thumbs' => [
    'quality' => 80,
    'format'  => 'webp',
    'srcsets' => [
      'default' => [
        '400w'  => ['width' => 400],
        '800w'  => ['width' => 800],
        '1200w' => ['width' => 1200],
        '1600w' => ['width' => 1600],
        '2000w' => ['width' => 2000],
        '2400w' => ['width' => 2400],
      ],
    ],
  ],

  'languages' => [
    'detect' => true,
  ],



  'yaml.handler' => 'symfony',
  'smartypants'  => false,

  // KQL public : uniquement utilisé en local par le build 11ty (kql.js),
  'kql.auth' => false,

  'jr.static_site_generator.output_folder'     => './static',
  'jr.static_site_generator.base_url'          => '/',
  'jr.static_site_generator.skip_media'        => false,
  'jr.static_site_generator.skip_plugin_assets' => true,
  'jr.static_site_generator.endpoint'          => 'generate-static-site',
  'jr.static_site_generator.custom_filters'    => [
    ['isDraft', false],
    ['isListed', true],
  ],

  
  'jr.static_site_generator.custom_routes'     => [
    [
      'path'  => 'feed.xml',
      'route' => 'feed',
    ],
  ],


  'markdown' => [
    'extra'  => true,
    'breaks' => true,
  ],

  // Surlignage des notes de bas de page (markdown + KirbyTag note:) dans
  // l'éditeur du champ Markdown. Voir plugin kirby-markdown-field-extras.
  'fabianmichael.markdown-field.customHighlights' => [
    [
      'name'  => 'footnote',
      'regex' => '\[\^[^\]]*\]|\(note\s*:\s*[^)\r\n]*\)',
      'class' => 'cm-footnote-full',
    ],
  ],

  'philippoehrlein.typo-and-paste' => [
    'characters' => [
      [
        'label' => ['en' => 'Quotation Marks / Spaces', 'fr' => 'Guillemets / Espaces'],
        'lang'  => 'fr',
        'characters' => [
          ['value' => '«',          'label' => ['fr' => 'Guillemet ouvrant',                  'en' => 'Left guillemet']],
          ['value' => '»',          'label' => ['fr' => 'Guillemet fermant',                  'en' => 'Right guillemet']],
          ['value' => '"',          'label' => ['fr' => 'Guillemet double ouvrant (anglais)', 'en' => 'Left double quotation mark']],
          ['value' => '"',          'label' => ['fr' => 'Guillemet double fermant (anglais)', 'en' => 'Right double quotation mark']],
          ['value' => "\u{00A0}",   'label' => ['fr' => 'Espace insécable',                   'en' => 'Non-breaking space']],
          ['value' => "\u{202F}",   'label' => ['fr' => 'Espace insécable fine',              'en' => 'Narrow non-breaking space']],
        ],
      ],
      [
        'label' => ['en' => 'Accented capitals', 'fr' => 'Capitales accentuées'],
        'characters' => [
          ['value' => 'À', 'label' => ['fr' => 'A accent grave',       'en' => 'A grave']],
          ['value' => 'Â', 'label' => ['fr' => 'A accent circonflexe', 'en' => 'A circumflex']],
          ['value' => 'Æ', 'label' => ['fr' => 'Ligature AE',          'en' => 'AE ligature']],
          ['value' => 'Ç', 'label' => ['fr' => 'C cédille',            'en' => 'C cedilla']],
          ['value' => 'È', 'label' => ['fr' => 'E accent grave',       'en' => 'E grave']],
          ['value' => 'É', 'label' => ['fr' => 'E accent aigu',        'en' => 'E acute']],
          ['value' => 'Ê', 'label' => ['fr' => 'E accent circonflexe', 'en' => 'E circumflex']],
          ['value' => 'Ë', 'label' => ['fr' => 'E tréma',              'en' => 'E umlaut']],
          ['value' => 'Î', 'label' => ['fr' => 'I accent circonflexe', 'en' => 'I circumflex']],
          ['value' => 'Ï', 'label' => ['fr' => 'I tréma',              'en' => 'I umlaut']],
          ['value' => 'Ô', 'label' => ['fr' => 'O accent circonflexe', 'en' => 'O circumflex']],
          ['value' => 'Œ', 'label' => ['fr' => 'Ligature OE',          'en' => 'OE ligature']],
          ['value' => 'Ù', 'label' => ['fr' => 'U accent grave',       'en' => 'U grave']],
          ['value' => 'Û', 'label' => ['fr' => 'U accent circonflexe', 'en' => 'U circumflex']],
          ['value' => 'Ü', 'label' => ['fr' => 'U tréma',              'en' => 'U umlaut']],
        ],
      ],
      [
        'label' => ['en' => 'Dashes', 'fr' => 'Tirets'],
        'characters' => [
          ['value' => '–', 'label' => ['fr' => 'Tiret moyen',   'en' => 'En dash']],
          ['value' => '—', 'label' => ['fr' => 'Tiret long',    'en' => 'Em dash']],
          ['value' => '‐', 'label' => ['fr' => 'Trait d\'union', 'en' => 'Hyphen']],
        ],
      ],
      [
        'label' => ['en' => 'Arrows', 'fr' => 'Flèches'],
        'characters' => [
          ['value' => "←\u{FE0E}", 'label' => ['fr' => 'Flèche gauche',        'en' => 'Left arrow']],
          ['value' => "→\u{FE0E}", 'label' => ['fr' => 'Flèche droite',        'en' => 'Right arrow']],
          ['value' => "↑\u{FE0E}", 'label' => ['fr' => 'Flèche haut',          'en' => 'Up arrow']],
          ['value' => "↓\u{FE0E}", 'label' => ['fr' => 'Flèche bas',           'en' => 'Down arrow']],
          ['value' => "↔\u{FE0E}", 'label' => ['fr' => 'Flèche gauche-droite', 'en' => 'Left-right arrow']],
          ['value' => "↕\u{FE0E}", 'label' => ['fr' => 'Flèche haut-bas',      'en' => 'Up-down arrow']],
          ['value' => "↖\u{FE0E}", 'label' => ['fr' => 'Flèche haut-gauche',   'en' => 'Up-left arrow']],
          ['value' => "↗\u{FE0E}", 'label' => ['fr' => 'Flèche haut-droite',   'en' => 'Up-right arrow']],
          ['value' => "↘\u{FE0E}", 'label' => ['fr' => 'Flèche bas-droite',    'en' => 'Down-right arrow']],
          ['value' => "↙\u{FE0E}", 'label' => ['fr' => 'Flèche bas-gauche',    'en' => 'Down-left arrow']],
        ],
      ],
      [
        'label' => ['en' => 'Miscellaneous', 'fr' => 'Divers'],
        'characters' => [
          ['value' => '…', 'label' => ['fr' => 'Points de suspension', 'en' => 'Ellipsis']],
          ['value' => '°', 'label' => ['fr' => 'Symbole degré',         'en' => 'Degree sign']],
          ['value' => '§', 'label' => ['fr' => 'Paragraphe',            'en' => 'Section sign']],
          ['value' => '¶', 'label' => ['fr' => 'Alinéa',                'en' => 'Pilcrow']],
          ['value' => '©', 'label' => ['fr' => 'Copyright',             'en' => 'Copyright']],
          ['value' => '®', 'label' => ['fr' => 'Marque déposée',        'en' => 'Registered trademark']],
          ['value' => '™', 'label' => ['fr' => 'Marque commerciale',    'en' => 'Trademark']],
        ],
      ],
    ],
  ],

  'routes' => [
    [
      'pattern' => '(feed|feed.xml)',
      'method'  => 'GET',
      'action'  => function () {
        $allPublications = page('publications')?->children()->listed() ?? pages();

        $cards = [];
        foreach ($allPublications as $pub) {
          if ($pub->home_principal()->toBool() && $pub->auteur_principal()->isNotEmpty()) {
            $cards[] = [
              'guid'   => $pub->url() . '#tab-principal',
              'url'    => $pub->url() . '#tab-principal',
              'titre'  => $pub->titre_principal_home()->isNotEmpty() ? $pub->titre_principal_home() : $pub->titre_principal(),
              'auteur' => $pub->auteur_principal(),
              'intro'  => $pub->intro_principal(),
              'date'   => $pub->modified('c', 'date'),
            ];
          }
          if ($pub->home_secondaire()->toBool() && $pub->auteur_secondaire()->isNotEmpty()) {
            $cards[] = [
              'guid'   => $pub->url() . '#tab-secondaire',
              'url'    => $pub->url() . '#tab-secondaire',
              'titre'  => $pub->titre_secondaire_home()->isNotEmpty() ? $pub->titre_secondaire_home() : $pub->titre_secondaire(),
              'auteur' => $pub->auteur_secondaire(),
              'intro'  => $pub->intro_secondaire(),
              'date'   => $pub->modified('c', 'date'),
            ];
          }
        }

        $siteTitle = \Kirby\Toolkit\Xml::encode(site()->title()->value());
        $siteUrl   = \Kirby\Toolkit\Xml::encode(site()->url());
        $feedUrl   = \Kirby\Toolkit\Xml::encode(site()->url() . '/feed.xml');
        $updated   = !empty($cards) ? $cards[0]['date'] : date('c');

        $entries = '';
        foreach ($cards as $card) {
          $auteur  = \Kirby\Toolkit\Xml::encode($card['auteur']->value());
          $titre   = \Kirby\Toolkit\Xml::encode(str_replace("\u{00AD}", '', strip_tags(html_entity_decode($card['titre']->value(), ENT_HTML5 | ENT_QUOTES, 'UTF-8'))));
          $guid    = \Kirby\Toolkit\Xml::encode($card['guid']);
          $url     = \Kirby\Toolkit\Xml::encode($card['url']);
          $date    = $card['date'];
          $intro   = $card['intro']->isNotEmpty() ? str_replace(["\u{00AD}", '&shy;'], '', $card['intro']->toBlocks()->toHtml()) : '';
          $content = $intro ? "<content type=\"html\"><![CDATA[{$intro}]]></content>" : '';
          $entries .= "  <entry>\n    <title>{$titre}</title>\n    <link href=\"{$url}\" />\n    <updated>{$date}</updated>\n    <id>{$guid}</id>\n    <author><name>{$auteur}</name></author>\n    {$content}\n  </entry>\n";
        }

        $xml  = '<?xml version="1.0" encoding="utf-8"?>' . "\n";
        $xml .= "<feed xmlns=\"http://www.w3.org/2005/Atom\" xml:lang=\"fr\">\n";
        $xml .= "  <title>{$siteTitle}</title>\n";
        $xml .= "  <subtitle>{$siteTitle}</subtitle>\n";
        $xml .= "  <link href=\"{$feedUrl}\" rel=\"self\" />\n";
        $xml .= "  <link href=\"{$siteUrl}/\" />\n";
        $xml .= "  <updated>{$updated}</updated>\n";
        $xml .= "  <id>{$siteUrl}/</id>\n";
        $xml .= $entries;
        $xml .= "</feed>";

        return new \Kirby\Http\Response($xml, 'application/atom+xml');
      },
    ],
  ],

];
