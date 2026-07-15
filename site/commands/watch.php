<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Active la mise à jour automatique du site statique : lance `npm run serve`
 * (Eleventy avec --serve --ignore-initial --incremental) en tâche de fond.
 * Ne régénère rien au démarrage (le site doit déjà avoir été généré) ; chaque
 * enregistrement dans le Panel ne met à jour que ce qui a changé dans /static.
 * Reste actif jusqu'à l'extinction de la machine (relancer le bouton signale
 * simplement que le mécanisme tourne déjà).
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby watch
 */
return [
    'description' => 'Watch content and rebuild the static site automatically',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        $key         = (string) $cli->arg('command');
        $eleventyDir = kirby()->root() . '/11ty';
        $logFile     = kirby()->root() . '/logs/watch.log';

        $running = static function (): bool {
            $fp = @fsockopen('localhost', 8080, $errno, $errstr, 1);
            if ($fp) {
                fclose($fp);
                return true;
            }
            return false;
        };

        if ($running()) {
            $cli->success('Mise à jour automatique déjà active');
            janitor()->data($key, [
                'status'          => 200,
                'message'         => 'Mise à jour automatique déjà active',
                'label'           => site()->watchButtonLabel(),
                'backgroundColor' => 'var(--color-green-300)',
                'color'           => '#000000',
            ]);
            return;
        }

        $isWin = DIRECTORY_SEPARATOR === '\\';
        $null  = $isWin ? 'NUL' : '/dev/null';

        @file_put_contents($logFile, date('c') . " watch lancé\n", FILE_APPEND);

        // `< NUL` : donne à node un STDIN vide mais valide (cf. deploy.php)
        // pclose(popen(...)) : rend la main dès que le process est lancé,
        // là où exec() resterait bloqué tant que le serveur tourne.
        if ($isWin) {
            $cmd = 'start /B "" cmd /C "cd /D ' . escapeshellarg($eleventyDir)
                 . ' && npm run serve < ' . $null . ' >> ' . escapeshellarg($logFile) . ' 2>&1"';
            pclose(popen($cmd, 'r'));
        } else {
            $cmd = 'cd ' . escapeshellarg($eleventyDir)
                 . ' && nohup npm run serve < ' . $null . ' >> ' . escapeshellarg($logFile) . ' 2>&1 &';
            exec($cmd);
        }

        // Avec --ignore-initial il n'y a pas de build au démarrage :
        // le serveur répond en quelques secondes
        for ($i = 0; $i < 20 && $running() === false; $i++) {
            usleep(500000);
        }

        if ($running()) {
            $cli->success('Mise à jour automatique active');
            janitor()->data($key, [
                'status'          => 200,
                'message'         => 'Mise à jour automatique active',
                'label'           => site()->watchButtonLabel(),
                'backgroundColor' => 'var(--color-green-300)',
                'color'           => '#000000',
            ]);
        } else {
            $cli->error('Le mécanisme n\'a pas démarré');
            janitor()->data($key, [
                'status'  => 500,
                'message' => 'Le mécanisme n\'a pas démarré (voir logs/watch.log)',
            ]);
        }
    },
];
