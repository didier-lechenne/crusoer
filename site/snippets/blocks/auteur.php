<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php
include __DIR__ . '/block-options.php';
array_unshift($classes, 'auteur', 'block', 'block-type-markdown');
$classAttr = ' class="' . implode(' ', $classes) . '"';
?>

<div<?= $classAttr ?><?= $styleAttr ?>>
    <?= $block->text()->kti()->orthotypo() ?>
</div>
