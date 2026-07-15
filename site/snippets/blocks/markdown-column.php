<?php /** @var \Kirby\Cms\Block $block */ ?>
<?php
include __DIR__ . '/block-options.php';

// Vertical alignment via inline style (overrides .grid .block { margin: 0 })
$vAlignStyles = ['self-start' => 'margin-bottom:auto', 'self-center' => 'margin-top:auto;margin-bottom:auto', 'self-end' => 'margin-top:auto'];
if ($verticalAlign && isset($vAlignStyles[$verticalAlign])) {
    $classes = array_filter($classes, fn($c) => $c !== $verticalAlign);
    $styleAttr = $styleAttr
        ? rtrim($styleAttr, '"') . ';' . $vAlignStyles[$verticalAlign] . '"'
        : ' style="' . $vAlignStyles[$verticalAlign] . '"';
}


$classAttr = ' class="' . implode(' ', $classes) . '"';
?>

<div data-block="markdown"  <?= $classAttr ?><?= $styleAttr ?>>
    <?= $block->text()->kirbytext()->orthotypo() ?>
</div>
