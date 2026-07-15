<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Déploie le site statique (./static) vers Deuxfleurs (Garage) via dxfl.
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby deploy
 */
return [
    'description' => 'Deploy the static site to Deuxfleurs (Garage)',
    'args'        => Janitor::ARGS,
    'command'     => static function (CLI $cli): void {
        set_time_limit(0);

        $c       = kirby()->option('deuxfleurs', []);
        $website = $c['websiteId'] ?? null;
        $dir     = kirby()->root() . '/static';
        $key     = (string) $cli->arg('command');

        if (!$website) {
            janitor()->data($key, ['status' => 400, 'message' => 'deuxfleurs.websiteId manquant']);
            return;
        }

        // Clés S3 attendues par dxfl (héritées par le process enfant)
        putenv('AWS_ACCESS_KEY_ID='     . ($c['keyId'] ?? ''));
        putenv('AWS_SECRET_ACCESS_KEY=' . ($c['keySecret'] ?? ''));

        // dxfl installé dans le projet : npm install dxfl
        $isWin = DIRECTORY_SEPARATOR === '\\';
        $dxfl  = kirby()->root() . '/node_modules/.bin/dxfl' . ($isWin ? '.cmd' : '');
        $null  = $isWin ? 'NUL' : '/dev/null';

        // `< NUL` : donne à node un STDIN vide mais valide. Sans ça, en contexte
        // web (PHP-FPM), l'entrée standard est invalide → node plante (EISDIR).
        $cmd = escapeshellarg($dxfl) . ' deploy '
             . escapeshellarg($website) . ' '
             . escapeshellarg($dir) . ' --yes < ' . $null . ' 2>&1';

        exec($cmd, $out, $code);
        @file_put_contents(kirby()->root() . '/logs/deploy.log', date('c') . " (exit $code)\n" . implode("\n", $out) . "\n\n", FILE_APPEND);

        if ($code === 0) {
            $cli->success('Déployé sur Deuxfleurs');
            janitor()->data($key, ['status' => 200, 'message' => 'Déployé sur Deuxfleurs ✓']);
        } else {
            $cli->error(implode("\n", $out));
            janitor()->data($key, ['status' => 500, 'message' => 'Échec : ' . implode(' | ', array_slice($out, -3))]);
        }
    },
];
