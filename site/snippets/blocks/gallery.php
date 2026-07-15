<?php
/** @var \Kirby\Cms\Block $block */
$images = $block->images()->toFiles();
$count = $images->count();
?>
<figure data-block="gallery"  class="gallery">
  <ul class="gallery-grid" style="--columns: <?= $count ?>">
    <?php foreach ($images as $image): ?>
    <li class="gallery-item gallery-image">
      <a data-lightbox href="<?= $image->resize(1200)->url() ?>">
      <figure style="
            --ratio: <?= $block->ratio()->or('auto') ?>;
            --fit: <?= $block->crop()->isFalse() ? 'contain' : 'cover' ?>
          ">
      <img
          src="<?= $image->resize(600)->url() ?>"
          srcset="<?= $image->srcset('default') ?>"
          sizes="(min-width: 1200px) 1200px, (min-width: 900px) 900px, (min-width: 600px) 600px, 100vw"
          alt="<?= esc($image->alt(), 'attr') ?>"
        >
      <?php if ($image->caption()->isNotEmpty()): ?>
      <figcaption><?= $image->caption()->kti()->orthotypo() ?></figcaption>
      <?php endif ?>
    </figure>
      </a>
    </li>
    <?php endforeach ?>
  </ul>
  <?php if ($block->caption()->isNotEmpty()): ?>
  <figcaption>
    <?= $block->caption()->text()->orthotypo() ?>
  </figcaption>
  <?php endif ?>
</figure>