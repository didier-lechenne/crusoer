<?php
// Si le contenu a du HTML brut dans "text"
if ($block->text()->isNotEmpty()):
  echo $block->text()->kt();
// Sinon utiliser la structure "items"
elseif ($block->items()->isNotEmpty()):
  $type = $block->type() === 'bullet' ? 'ul' : 'ol';
?>
<<?= $type ?> data-block="list" class="block-list text block">
  <?php foreach ($block->items()->toArray() as $item): ?>
  <li><?= kirbytext($item) ?></li>
  <?php endforeach ?>
</<?= $type ?>>
<?php endif ?>