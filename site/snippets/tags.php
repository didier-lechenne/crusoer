<?php
/**
 * Snippet pour afficher les tags
 *
 * @param Page $page - La page dont on veut afficher les tags
 * @param bool $includeChildren - Inclure les tags des sous-pages (défaut: false)
 * @param string $baseUrl - URL de base pour les liens (défaut: 'publications')
 */

$page = $page ?? page();
$includeChildren = $includeChildren ?? false;
$baseUrl = $baseUrl ?? 'publications';

// Récupérer les tags de la page
$tags = $page->tags()->split();

// Si on veut inclure les tags des sous-pages (tous les descendants)
if ($includeChildren && $page->hasChildren()) {
    // index() retourne tous les descendants de manière récursive
    foreach ($page->index()->listed() as $descendant) {
        $descendantTags = $descendant->tags()->split();
        $tags = array_merge($tags, $descendantTags);
    }
    // Supprimer les doublons et trier
    $tags = array_unique($tags);
    sort($tags);
}

if (!empty($tags)): ?>
<div class="tags">
  <ul class="projet-tags">
    <?php foreach ($tags as $tag): ?>
    <li>
      <a href="<?= url($baseUrl) ?>?tag=<?= urlencode($tag) ?>"><?= esc($tag) ?></a>
    </li>
    <?php endforeach ?>
  </ul>
</div>
<?php endif ?>
