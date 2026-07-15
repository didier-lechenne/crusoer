<?php snippet("header") ?>

<main style="--color-muted: light-dark(rgb(93, 93, 93), rgb(179, 179, 179));">
  <section >
        <h1 class="projet-titre"><?= $page->titre_principal()->kti()->orthotypo() ?></h1>
        <?php foreach ($page->contenu_principal()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
  </section>
</main>

<?php snippet("footer") ?>
