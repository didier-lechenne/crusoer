<?php /** @var \Kirby\Cms\Block $block */ ?>

<?php $layout = $block->layout()->toLayouts()->first() ?>
<?php
$gutterValue = $block->gutter()->isNotEmpty() ? $block->gutter()->value() : null;
$gutterStyle = $gutterValue ? '--gutter: ' . $gutterValue . 'mm' : '';

$classes = ['grid'];
if ($block->fullWidth()->isTrue())           $classes[] = 'fullwidth';
if ($block->class()->isNotEmpty())           $classes[] = $block->class()->value();
$classAttr = implode(' ', $classes);
$styleAttr = $gutterStyle ? ' style="' . $gutterStyle . '"' : '';
?>

<?php if ($layout !== null): ?>

  <section data-block="column"  class="<?= $classAttr ?>" <?= $styleAttr ?>>
    <?php foreach ($layout->columns() as $column): ?>
      <div class="column" style="--columns:<?= $column->span() ?>">
          <?= $column->blocks() ?>
      </div>
    <?php endforeach ?>
  </section>

<?php endif ?>