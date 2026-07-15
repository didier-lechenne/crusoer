<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Sert le site statique (./static) tel quel sur http://localhost:8081,
 * pour vérifier le build avant de le déployer chez Deuxfleurs.
 * Démarre eleventy-dev-server en arrière-plan s'il ne tourne pas déjà.
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby preview
 */
return [
    'description' => 'Preview the static site before deploying',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        $key         = (string) $cli->arg('command');
        $eleventyDir = kirby()->root() . '/11ty';
        $logFile     = kirby()->root() . '/logs/preview.log';
        $url         = 'http://localhost:8081';

        $running = static function (): bool {
            $fp = @fsockopen('localhost', 8081, $errno, $errstr, 1);
            if ($fp) {
                fclose($fp);
                return true;
            }
            return false;
        };

        if ($running()) {
            $cli->success('Prévisualisation déjà lancée : ' . $url);
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Prévisualisation déjà lancée',
                'open'    => $url,
            ]);
            return;
        }

        if (is_dir(kirby()->root() . '/static') === false) {
            janitor()->data($key, [
                'status'  => 400,
                'message' => 'Aucun dossier ./static : lancer un build d\'abord',
            ]);
            return;
        }

        $isWin = DIRECTORY_SEPARATOR === '\\';
        $null  = $isWin ? 'NUL' : '/dev/null';

        @file_put_contents($logFile, date('c') . " preview lancé\n", FILE_APPEND);

        // `< NUL` : donne à node un STDIN vide mais valide (cf. deploy.php)
        // pclose(popen(...)) : rend la main dès que le process est lancé,
        // là où exec() resterait bloqué tant que le serveur tourne.
        if ($isWin) {
            $cmd = 'start /B "" cmd /C "cd /D ' . escapeshellarg($eleventyDir)
                 . ' && npm run preview < ' . $null . ' >> ' . escapeshellarg($logFile) . ' 2>&1"';
            pclose(popen($cmd, 'r'));
        } else {
            $cmd = 'cd ' . escapeshellarg($eleventyDir)
                 . ' && nohup npm run preview < ' . $null . ' >> ' . escapeshellarg($logFile) . ' 2>&1 &';
            exec($cmd);
        }

        // Attend que le serveur réponde (max ~5 s)
        for ($i = 0; $i < 10 && $running() === false; $i++) {
            usleep(500000);
        }

        if ($running()) {
            $cli->success('Prévisualisation sur ' . $url);
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Prévisualisation sur ' . $url,
                'open'    => $url,
            ]);
        } else {
            $cli->error('Le serveur de prévisualisation n\'a pas démarré');
            janitor()->data($key, [
                'status'  => 500,
                'message' => 'Le serveur n\'a pas démarré (voir logs/preview.log)',
            ]);
        }
    },
];
