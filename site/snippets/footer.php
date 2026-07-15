    <footer class="footer">
      <?php $about = page('about'); ?>
      <?php $mentions = page('mentions-legales'); ?>

      <?php if ($about): ?>
      <a href="<?= $about->url() ?>">A propos</a>
      <?php endif ?>
      <?php if ($about && $mentions): ?> · <?php endif ?>
      <?php if ($mentions): ?>
      <a href="<?= $mentions->url() ?>">Mentions legales</a>
      <?php endif ?>
      <?php if ($about || $mentions): ?> · <?php endif ?>
      <a href="<?= site()->url() ?>/feed.xml">Flux RSS</a>
    </footer>

    <?= js('assets/lightbox/lightbox.js') ?>
    <?= js('assets/js/main.js') ?>
    <?= js('assets/js/url-breaks.js') ?>
    <?= js('assets/js/sideNotes.js') ?>


    

</body>
</html>
