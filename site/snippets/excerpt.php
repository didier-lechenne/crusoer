<a href="<?= $article->url() ?>">
  <h2 class="projet-excerpt-title">
    <?= $article->titre_principal()->kti()->orthotypo() ?>
  </h2>

  <?php if ($article->auteur_principal()->isNotEmpty()): ?>
  <div class="projet-excerpt-auteur">
    <?= $article->auteur_principal()->kti()->orthotypo() ?>
  </div>
  <?php endif ?>

  <?php if ($article->annee_principal()->isNotEmpty()): ?>
  <div class="projet-excerpt-year">
    <?= $article->annee_principal()->kti()->orthotypo() ?>
  </div>
  <?php endif ?>
</a>
