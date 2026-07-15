    <title><?= r($page !== $site->homePage(), $page->title()->html() . ' | ') . $site->title()->html() ?></title>

    <meta name="description" content="<?php e($page->text()->isNotEmpty(), $page->text()->excerpt(150)->text(), $site->description()->text()) ?>">
    

<link rel="icon" type="image/png" href="/assets/images/favicon-96x96.png?v=20260518" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg?v=20260518" />
<link rel="shortcut icon" href="/assets/images/favicon.ico?v=20260518" />
<link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png?v=20260518" />
<meta name="apple-mobile-web-app-title" content="CRUSOER" />
<link rel="manifest" href="/assets/images/site.webmanifest?v=20260518" />


    <meta property="og:url" content="<?= $site->url() ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= r($page !== $site->homePage(), $page->title()->html() . ' | ') . $site->title()->html() ?>">
    <meta property="og:description" content="<?php e($page->intro()->isNotEmpty(), $page->intro()->text(), $site->description()->text()) ?>">
    <meta property="og:site_name" content="<?= $site->title() ?>">
    <meta property="og:locale" content="<?= $kirby->language() ?? 'fr_FR' ?>">
    <link rel="alternate" type="application/rss+xml" title="<?= $site->title()->html() ?> RSS" href="<?= site()->url() ?>/feed">

    <?php
        if ($page->cover()->isNotEmpty()) {
            $cover = $page->cover()->toFile();
        } else {
            $cover = page('home')->images()->first();
        }
        if ($cover) :
            $og_cover = $cover->thumb(['width' => 1200, 'height' => 630, 'crop' => true]);
    ?>

    <meta property="og:image" content="<?= $og_cover->url() ?>">
    <meta property="og:image:width" content="<?= $og_cover->width() ?>">
    <meta property="og:image:height" content="<?= $og_cover->height() ?>">
    <?php endif ?>
