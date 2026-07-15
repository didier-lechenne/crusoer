<?php
use Kirby\Cms\Html;

/** @var \Kirby\Cms\Block $block */
$caption = $block->caption()->text()->orthotypo();

$url   = null;
$attrs = [];
$coverUrl    = null;
$embedUrl    = null;
$isExternal  = false;

if ($block->location() == 'kirby' && $video = $block->video()->toFile()) {
    $url = $video->url();
    $attrs = array_filter([
        'autoplay'    => $block->autoplay()->toBool(),
        'controls'    => $block->controls()->toBool(),
        'loop'        => $block->loop()->toBool(),
        'muted'       => $block->muted()->toBool() || $block->autoplay()->toBool(),
        'playsinline' => $block->autoplay()->toBool(),
        'preload'     => $block->preload()->value(),
    ]);
    if ($poster = $block->poster()->toFile()) {
        $coverUrl = $poster->url();
    }
} elseif ($block->url()->isNotEmpty()) {
    $url        = $block->url()->value();
    $isExternal = true;
    if ($cover = $block->cover()->toFile()) {
        $coverUrl = $cover->url();
    }
    // Construire l'URL d'embed avec autoplay
    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $m)) {
        $embedUrl = 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?autoplay=1';
    } elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $m)) {
        $embedUrl = 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1';
    }
}

$captionLocation = $block->captionLocation()->value();
$captionAlign    = $block->captionAlign()->value();
$figureClasses   = array_filter([
    'video',
    $captionLocation === 'below' ? 'caption-below' : null,
    $captionLocation !== 'below' && $captionAlign === 'top' ? 'caption-top' : null,
    $block->class()->isNotEmpty() ? $block->class()->value() : null,
]);

$videoHtml = !$isExternal && $url ? Html::video($url, [], $attrs) : null;

if ($url):
?>
<figure data-block="video" class="<?= implode(' ', $figureClasses) ?>">
  <div class="video-container">
    <?php if ($coverUrl): ?>
    <div class="video-facade" <?= $isExternal && $embedUrl ? 'data-src="' . $embedUrl . '" data-type="external"' : 'data-type="internal"' ?>>
      <img src="<?= $coverUrl ?>" alt="">
      <button class="video-play" aria-label="<?= t('video.play', 'Lire la vidéo') ?>">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>
      </button>
    </div>
    <?php if (!$isExternal && $videoHtml): ?>
    <div class="video-player" hidden><?= $videoHtml ?></div>
    <?php endif ?>
    <?php elseif ($isExternal): ?>
    <?= Html::video($url, [], []) ?>
    <?php else: ?>
    <?= $videoHtml ?>
    <?php endif ?>
  </div>

  <?php if ($caption->isNotEmpty()): ?>
  <figcaption><?= $caption ?></figcaption>
  <?php endif ?>
</figure>
<?php endif ?>
