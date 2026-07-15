<?php snippet("header") ?>

<main class="home">
  <?php
  $publicationsParent = page("publications");
  $allPublications = $publicationsParent
    ? $publicationsParent->children()->listed()
    : pages();

  // Construit une liste de cartes : chaque entrée = [publication, tab, hash]
  $cards = [];
  foreach ($allPublications as $publication) {
    if ($publication->home_principal()->toBool()) {
      $cards[] = ['pub' => $publication, 'tab' => 'principale', 'hash' => '#tab-principal'];
    }
    if ($publication->home_secondaire()->toBool()) {
      $cards[] = ['pub' => $publication, 'tab' => 'secondaire', 'hash' => '#tab-secondaire'];
    }
  }
  ?>

  <?php if (count($cards) > 0): ?>
    
  <div class="grid">
    <?php foreach ($cards as $card):
      $publication = $card['pub'];
      $hash = $card['hash'];
      $isSecondaire = $card['tab'] === 'secondaire';
      $auteur = $isSecondaire ? $publication->auteur_secondaire()  : $publication->auteur_principal();
      $titreHome = $isSecondaire ? $publication->titre_secondaire_home() : $publication->titre_principal_home();
      $titre     = $titreHome->isNotEmpty() ? $titreHome : ($isSecondaire ? $publication->titre_secondaire() : $publication->titre_principal());
      $annee  = $isSecondaire ? $publication->annee_secondaire()   : $publication->annee_principal();
      $intro  = $isSecondaire ? $publication->intro_secondaire()   : $publication->intro_principal();
    ?>
    <div class="column" style="--columns: 4">
      
      <a href="<?= $publication->url() . $hash ?>">

        
      <div class="auteur_date">
        <?php if ($auteur->isNotEmpty()): ?>
          <span class="auteur">
            <?= $auteur->kti()->orthotypo() ?>
          </span>
        <?php endif ?>
          <?php if ($annee->isNotEmpty()): ?>
          <span class="date">
            <span class="puce">/</span> <?= $annee->kti()->orthotypo() ?>
          </span>
          <?php endif ?>
        
      </div>

<hr>
        <h2 class="titre">
          <?= $titre->kti()->orthotypo() ?>
        </h2>



        <?php if ($intro->isNotEmpty()): ?>
          
        <div class="intro">
          
          <?php foreach ($intro->toBlocks() as $block): ?>
            <?php snippet('blocks/' . $block->type(), ['block' => $block]) ?>
          <?php endforeach ?>
        </div>
        <?php endif ?>

      </a>
          </div>
    <?php endforeach ?>
          </div>
        
  <?php endif ?>
</main>

<?php snippet("footer") ?>
