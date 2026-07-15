<?php

/** @var \Kirby\Cms\Block $block */
$file = $block->source()->toFile();
if (!$file) return;

$captionLocation = $block->captionLocation()->value();
$captionAlign    = $block->captionAlign()->value();
$figureClasses   = array_filter([
    'audio',
    $captionLocation === 'below' ? 'caption-below' : null,
    $captionLocation !== 'below' && $captionAlign === 'top' ? 'caption-top' : null,
]);

$hasCaption = $block->title()->isNotEmpty()
    || $block->description()->isNotEmpty();
?>
<figure class="<?= implode(' ', $figureClasses) ?>">
  <audio preload="auto" controls>
    <source src="<?= $file->url() ?>" type="<?= $file->mime() ?>">
  </audio>

  <?php if ($hasCaption): ?>
  <figcaption>
    <?php if ($block->description()->isNotEmpty()): ?>
    <?= $block->description() ?>
    <?php endif ?>
  </figcaption>
  <?php endif ?>
</figure>
