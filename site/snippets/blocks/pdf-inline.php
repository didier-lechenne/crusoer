<?php
/** @var \Kirby\Cms\Block $block */
$pdf = $block->pdf()->toFile();
$height = $block->height()->or(800)->value();
?>
<?php if ($pdf): ?>
<figure data-block="pdf-inline" class="pdfinline">

  <iframe
    src="<?= $pdf->url() ?>"
    width="100%"
    height="<?= $height ?>"
    title="<?= $pdf->filename() ?>"
    loading="lazy"
  ></iframe>
  <?php if ($block->caption()->isNotEmpty()): ?>
  <figcaption class="figcaption"><?= $block->caption()->escape() ?></figcaption>
  <?php endif ?>
</figure>
  <a href="<?= $pdf->url() ?>" data-lightbox="pdf" class="pdfnote__trigger like-notes" aria-label="Plein écran">
    
  Plein écran

    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/>
      <line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/>
    </svg> -->
  </a>
<?php endif ?>
