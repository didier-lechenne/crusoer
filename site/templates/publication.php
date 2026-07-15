<?php snippet("header") ?>

<main>

  <?php $hasSecondaire = $page->contenu_secondaire()->isNotEmpty() ?>

  <?php if ($hasSecondaire): ?>

  <div class="tabset-contenu">

    <input type="radio" name="tabset" id="tab-principal" checked>
    <input type="radio" name="tabset" id="tab-secondaire">

    <?php if ($page->chapo_principal()->isNotEmpty()): ?>
    <div class="chapo chapo-tab chapo-tab-principal">
        <?php foreach ($page->chapo_principal()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
      
    </div>
    <?php endif ?>
    <?php if ($page->chapo_secondaire()->isNotEmpty()): ?>
    <div class="chapo chapo-tab chapo-tab-secondaire">
        <?php foreach ($page->chapo_secondaire()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
    </div>
    <?php endif ?>

    <div class="all-tab">
      <label class="tabset-contenu" for="tab-principal"><?= $page->onglet_principal()->kti()->orthotypo() ?></label>
      <label class="tabset-contenu" for="tab-secondaire"><?= $page->onglet_secondaire()->kti()->orthotypo() ?></label>
    </div>

    <div id="tab-panels" class="tab-panels">

      <section id="tab1" class="tab-panel-contenu tab-panel-1">
        <?php if ($page->auteur_principal()->isNotEmpty() || $page->annee_principal()->isNotEmpty()): ?>
        <div class="projet-meta">
          <?= $page->auteur_principal()->kti()->orthotypo() ?>
          <?php if ($page->auteur_principal()->isNotEmpty() && $page->annee_principal()->isNotEmpty()): ?> <span class="puce">/</span> <?php endif ?>
          <?= $page->annee_principal()->kti()->orthotypo() ?>
        </div>
        <?php endif ?>
        <h1 class="projet-titre"><?= $page->titre_principal()->kti()->orthotypo() ?></h1>
        <?php foreach ($page->contenu_principal()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
      </section>

      <section id="tab2" class="tab-panel-contenu tab-panel-2">
        <?php if ($page->auteur_secondaire()->isNotEmpty() || $page->annee_secondaire()->isNotEmpty()): ?>
        <div class="projet-meta">
          <?= $page->auteur_secondaire()->kti()->orthotypo() ?>
          <?php if ($page->auteur_secondaire()->isNotEmpty() && $page->annee_secondaire()->isNotEmpty()): ?> <span class="puce">/</span> <?php endif ?>
          <?= $page->annee_secondaire()->kti()->orthotypo() ?>
        </div>
        <?php endif ?>
        <h1 class="projet-titre"><?= $page->titre_secondaire()->kti()->orthotypo() ?></h1>
        <?php foreach ($page->contenu_secondaire()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
      </section>

    </div>
  </div>

  <?php else: ?>

    <?php if ($page->chapo_principal()->isNotEmpty()): ?>
    <div class="chapo">
        <?php foreach ($page->chapo_principal()->toBlocks() as $block): ?>
          <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
        <?php endforeach ?>
    </div>
    <?php endif ?>
    <?php if ($page->auteur_principal()->isNotEmpty() || $page->annee_principal()->isNotEmpty()): ?>
    <div class="projet-meta">
      <?= $page->auteur_principal()->kti()->orthotypo() ?>
      <?php if ($page->auteur_principal()->isNotEmpty() && $page->annee_principal()->isNotEmpty()): ?> / <?php endif ?>
      <?= $page->annee_principal()->kti()->orthotypo() ?>
    </div>
    <?php endif ?>
    <h1 class="projet-titre"><?= $page->titre_principal()->kti()->orthotypo() ?></h1>
    
      <?php foreach ($page->contenu_principal()->toBlocks() as $block): ?>
        <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
      <?php endforeach ?>
   

  <?php endif ?>

</main>

<?php snippet("footer") ?>
