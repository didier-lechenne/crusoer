<?php

Kirby::plugin('dlechenne/pdf-block', [
  'blueprints' => [
    'blocks/pdf' => __DIR__ . '/blueprints/blocks/pdf.yml',
    'files/pdf'  => __DIR__ . '/blueprints/files/pdf.yml',
  ],
  'snippets' => [
    'blocks/pdf' => __DIR__ . '/snippets/blocks/pdf.php',
  ],
]);