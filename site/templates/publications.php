<?php snippet("header") ?>

<main>
  <?php $publications = $page->children()->listed(); ?>

  <?php if ($publications->count() > 0): ?>
  <ul class="grid">
    <?php foreach ($publications as $publication): ?>
    <li class="column" style="--columns: 3">
      <?php snippet("excerpt", ["article" => $publication]) ?>
    </li>
    <?php endforeach ?>
  </ul>
  <?php endif ?>
</main>

<?php snippet("footer") ?>
