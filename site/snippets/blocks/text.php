<?php
$content = $block->text()->orthotypo();
$textAlign = $block->textAlign()->isNotEmpty() ? $block->textAlign() : null;
$textSize = $block->textSize()->isNotEmpty() ? $block->textSize() : null;
$fontFamily = $block->fontFamily()->isNotEmpty() ? $block->fontFamily() : null;
$verticalAlign = $block->verticalAlign()->isNotEmpty() ? $block->verticalAlign() : null;
$textColor = $block->textColor()->isNotEmpty() ? $block->textColor() : null;

$styleAttributes = [];
// if($textSize) {
//   $styleAttributes[] = "font-size: var(--" . $textSize . ")";
// }
// if($fontFamily) {
//   $styleAttributes[] = "font-family: var(--" . $fontFamily . ")";
// }
if($textColor) {
  $styleAttributes[] = "color: " . $textColor;
}

$styleString = !empty($styleAttributes) ? ' style="' . implode('; ', $styleAttributes) . ';"' : '';
?>

<div data-block="text" <?= $styleString ?> class="text block <?php if($textAlign): ?> <?= $textAlign ?><?php endif ?><?php if($verticalAlign): ?> <?= $verticalAlign ?><?php endif ?>">
  <?= $content ?>
</div>