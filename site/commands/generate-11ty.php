<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Génère la totalité du site statique avec 11ty (npm run build dans /11ty)
 * et attend la fin pour annoncer le vrai résultat (succès ou échec).
 * Le build rappelle ce même serveur Kirby via KQL (/api/query) : le serveur
 * local (Herd) traite plusieurs requêtes en parallèle, cela ne bloque pas.
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby generate-11ty
 */
return [
    'description' => 'Generate the whole static site with 11ty',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        set_time_limit(0);

        $key         = (string) $cli->arg('command');
        $eleventyDir = kirby()->root() . '/11ty';
        $logFile     = kirby()->root() . '/logs/generate-11ty.log';

        $isWin = DIRECTORY_SEPARATOR === '\\';
        $null  = $isWin ? 'NUL' : '/dev/null';

        @file_put_contents($logFile, date('c') . " build lancé\n", FILE_APPEND);

        // `< NUL` : donne à node un STDIN vide mais valide (cf. deploy.php)
        if ($isWin) {
            $cmd = 'cd /D ' . escapeshellarg($eleventyDir)
                 . ' && npm run build < ' . $null . ' 2>&1';
        } else {
            $cmd = 'cd ' . escapeshellarg($eleventyDir)
                 . ' && npm run build < ' . $null . ' 2>&1';
        }

        exec($cmd, $out, $code);
        @file_put_contents($logFile, implode("\n", $out) . "\n", FILE_APPEND);

        // Ligne de résumé d'Eleventy, ex. « Copied 379 Wrote 11 files in 7.61 seconds »
        $summary = '';
        foreach (array_reverse($out) as $line) {
            if (str_contains($line, 'Wrote')) {
                $summary = trim(str_replace('[11ty]', '', $line));
                break;
            }
        }

        if ($code === 0) {
            $cli->success('Site généré. ' . $summary);
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Site généré ✓ ' . $summary,
            ]);
        } else {
            $cli->error(implode("\n", array_slice($out, -3)));
            janitor()->data($key, [
                'status'  => 500,
                'message' => 'Échec de la génération (voir logs/generate-11ty.log)',
            ]);
        }
    },
];
