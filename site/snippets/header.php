<!DOCTYPE html>
<html lang="<?= $kirby->language() ?? 'fr' ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cleartype" content="on">

    <?php snippet("header.metas") ?>


    <link rel="alternate" type="application/rss+xml" title="Flux des publications de C R U S O E R" href="<?= site()->url() ?>/feed.xml"/>
   
    <?= css('assets/lightbox/lightbox.css') ?>
    <?= css('assets/css/index.css') ?>
    <?php snippet('link-color') ?>
    <style>:root {
      --bg-color-light: <?= $site->backgroundColorClair()->or('rgb(245, 245, 245)') ?>;
      --bg-color-dark: <?= $site->backgroundColorSombre()->or('rgb(38, 38, 38)') ?>;
    }</style>
    <script>(function(){var t=localStorage.getItem('theme');document.documentElement.setAttribute('data-theme',(t==='dark'||t==='light')?t:'light');}());</script>

</head>
<body
    data-intended-template="<?= $page->intendedTemplate() ?>"
    data-notes-mode="<?= $site->notesMode()->or('footnotes') ?>">


        <header class="header">

            <span class="logo"><a href="<?= $site->url() ?>/">C R U S O E R</a></span>
            <button class="theme-toggle" aria-label="Mode clair" title="Mode clair">☀</button>

        </header>
