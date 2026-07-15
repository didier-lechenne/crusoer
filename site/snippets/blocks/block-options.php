<?php

$textAlign     = $block->textAlign()->isNotEmpty()     ? $block->textAlign()->value()     : null;
$verticalAlign = $block->verticalAlign()->isNotEmpty() ? $block->verticalAlign()->value() : null;
$textColor     = $block->textColor()->isNotEmpty()     ? $block->textColor()->value()     : null;
$fontSize      = $block->fontSize()->isNotEmpty()      ? $block->fontSize()->value()      : null;
$fontFamily    = $block->fontFamily()->isNotEmpty()    ? $block->fontFamily()->value()    : null;
$lineHeight    = $block->lineHeight()->isNotEmpty()    ? $block->lineHeight()->value()    : null;
$fontWeight    = $block->fontWeight()->isNotEmpty()    ? $block->fontWeight()->value()    : null;
$extraClass    = $block->class()->isNotEmpty()         ? $block->class()->value()         : null;

$classes = [];
if ($textAlign)     $classes[] = $textAlign;
if ($verticalAlign) $classes[] = $verticalAlign;
if ($extraClass)    $classes[] = $extraClass;
if ($fontSize)  $classes[] = 'like-' . $fontSize . '';


$styleAttributes = [];
if ($textColor) {
  $styleAttributes[] = '--block-color-light: ' . $textColor;
  $classes[] = 'has-block-color';
}
if ($fontFamily) $styleAttributes[] = '--labeur-font-family: var(--' . $fontFamily . ')';
$styleAttr = !empty($styleAttributes) ? ' style="' . implode('; ', $styleAttributes) . ';"' : '';
