<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php
include __DIR__ . '/block-options.php';
$classAttr = ' class="' . implode(' ', $classes) . '"';
?>

<div data-block="markdown"  <?= $classAttr ?><?= $styleAttr ?>>
    <?= $block->text()->kirbytext()->orthotypo() ?>
</div>
