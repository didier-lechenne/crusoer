<?php

@include_once __DIR__ . '/vendor/autoload.php';

use Kirby\Cms\App as Kirby;
use Kirby\Toolkit\Str;
use Vanderlee\Syllable\Syllable;

Syllable::setCacheDir(kirby()->root('cache'));

Kirby::plugin('medienbaecker/hyphenate', [
  'options' => [
    'minWordLength' => 10,
    'language' => kirby()->language() ? Str::replace(kirby()->language()->locale()[0] ?? 'en-gb', '_', '-') : 'fr'
  ],
  'hooks' => [
    'kirbytext:after' => function (string|null $text) {

      $syllable = new Syllable(option('medienbaecker.hyphenate.language'));
      $syllable->setMinWordLength(option('medienbaecker.hyphenate.minWordLength'));

      libxml_use_internal_errors(true);
      $result = $syllable->hyphenateHtmlText($text);
      libxml_clear_errors();
      return $result;
    }
  ]
]);
