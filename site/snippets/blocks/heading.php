<?php
$level = $block->level()->or('h3')->value();
include __DIR__ . '/block-options.php';
array_unshift($classes, $level);
$classAttr = ' class="titre ' . implode(' ', $classes) . '"';
?>

<<?= $level ?> data-block="heading"<?= $classAttr ?><?= $styleAttr ?>>
  <?= $block->text()->kti()->orthotypo() ?>
</<?= $level ?>>
