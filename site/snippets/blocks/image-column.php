<?php

/** @var \Kirby\Cms\Block $block */
$alt     = $block->alt();
$caption = $block->caption();
$crop    = $block->crop()->isTrue();
$link    = $block->link();
$ratio   = $block->ratio()->or('auto');
$src     = null;

if ($block->location() == 'web') {
    $src = $block->src()->esc();
} elseif ($image = $block->image()->toFile()) {
    $alt = $alt->or($image->alt());
    $src = $image->url();
}

$verticalAlign = $block->verticalAlign()->isNotEmpty() ? $block->verticalAlign()->value() : null;

?>
<?php if ($src): ?>
<figure<?= Html::attr(['data-block' => 'image', 'class' => $verticalAlign ?: null, 'data-ratio' => $ratio, 'data-crop' => $crop], null, ' ') ?>>
  <?php if ($link->isNotEmpty()): ?>
  <a data-lightbox="imagenote" href="<?= Str::esc($link->toUrl()) ?>">
    <?php if ($image): ?>
    <img
      src="<?= $image->resize(1200)->url() ?>"
      srcset="<?= $image->srcset('default') ?>"
      sizes="(min-width: 1200px) 1200px, 100vw"
      alt="<?= $alt->esc() ?>"
    >
    <?php else: ?>
    <img src="<?= $src ?>" alt="<?= $alt->esc() ?>">
    <?php endif ?>
  </a>
  <?php elseif ($image): ?>
  <a href="<?= $image->resize(2400)->url() ?>" data-lightbox="imagenote">
    <img
      src="<?= $image->resize(1200)->url() ?>"
      srcset="<?= $image->srcset('default') ?>"
      sizes="(min-width: 1200px) 1200px, 100vw"
      alt="<?= $alt->esc() ?>"
    >
  </a>
  <?php else: ?>
  <img src="<?= $src ?>" alt="<?= $alt->esc() ?>">
  <?php endif ?>

  <?php if ($caption->isNotEmpty()): ?>
  <figcaption>
    <?= $caption ?>
  </figcaption>
  <?php endif ?>
</figure>
<?php endif ?>
