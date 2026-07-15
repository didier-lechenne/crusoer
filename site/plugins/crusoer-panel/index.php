<?php

/**
 * Méthodes utilitaires pour le Panel.
 *
 * Utilisées par le bouton janitor « 2. Mise à jour automatique »
 * (site/blueprints/site.yml) pour refléter l'état du mécanisme
 * (npm run serve, port 8080, cf. site/commands/watch.php) :
 *
 *   - site.watchActive          → le serveur tourne-t-il ?
 *   - site.watchButtonLabel     → libellé selon l'état (fr/en)
 *   - site.watchButtonColor     → fond vert clair si actif
 *   - site.watchButtonTextColor → texte noir si actif (lisible sur le vert)
 *
 * Les queries « {{ site.… }} » du blueprint sont résolues à chaque
 * affichage du Panel : le bouton reflète l'état au chargement.
 */
Kirby::plugin('crusoer/panel', [
    'siteMethods' => [
        'watchActive' => function (): bool {
            $fp = @fsockopen('localhost', 8080, $errno, $errstr, 1);
            if ($fp) {
                fclose($fp);
                return true;
            }
            return false;
        },
        'watchButtonLabel' => function (string $lang = 'fr'): string {
            $labels = [
                'fr' => [
                    'active'   => '2. Mise à jour automatique ACTIVE — faites vos modifications dans Kirby',
                    'inactive' => '2. Activer la mise à jour automatique et faites vos modifications dans kirby.',
                ],
                'en' => [
                    'active'   => '2. Automatic update ACTIVE — edit your content in Kirby',
                    'inactive' => '2. Enable automatic update',
                ],
            ];
            $set = $labels[$lang] ?? $labels['fr'];
            return $this->watchActive() ? $set['active'] : $set['inactive'];
        },
        'watchButtonColor' => function (): string {
            return $this->watchActive() ? 'var(--color-green-300)' : '';
        },
        'watchButtonTextColor' => function (): string {
            return $this->watchActive() ? '#000000' : '';
        },
    ],
]);
