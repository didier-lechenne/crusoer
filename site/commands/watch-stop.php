<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Arrête la mise à jour automatique du site statique (le `npm run serve`
 * lancé par site/commands/watch.php) en tuant le process qui écoute sur
 * le port 8080.
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby watch-stop
 */
return [
    'description' => 'Stop the automatic update of the static site',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        $key = (string) $cli->arg('command');

        $running = static function (): bool {
            $fp = @fsockopen('localhost', 8080, $errno, $errstr, 1);
            if ($fp) {
                fclose($fp);
                return true;
            }
            return false;
        };

        if ($running() === false) {
            $cli->success('La mise à jour automatique est déjà arrêtée');
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Déjà arrêtée',
            ]);
            return;
        }

        $isWin = DIRECTORY_SEPARATOR === '\\';

        if ($isWin) {
            // Trouve le(s) PID qui écoutent sur le port 8080 et les termine
            exec('netstat -ano -p tcp 2>&1', $lines);
            $pids = [];
            foreach ($lines as $line) {
                if (str_contains($line, 'LISTENING') && preg_match('/:8080\s/', $line)) {
                    if (preg_match('/(\d+)\s*$/', trim($line), $m)) {
                        $pids[(int) $m[1]] = true;
                    }
                }
            }
            foreach (array_keys($pids) as $pid) {
                exec('taskkill /F /PID ' . (int) $pid . ' 2>&1');
            }
        } else {
            // macOS + Linux : lsof liste les PID qui écoutent sur le port ;
            // repli sur fuser (Linux sans lsof)
            exec('lsof -ti tcp:8080 2>/dev/null', $pids);
            if ($pids !== []) {
                foreach ($pids as $pid) {
                    exec('kill -9 ' . (int) $pid . ' 2>/dev/null');
                }
            } else {
                exec('fuser -k 8080/tcp 2>/dev/null');
            }
        }

        // Laisse au système le temps de fermer le port
        for ($i = 0; $i < 10 && $running(); $i++) {
            usleep(500000);
        }

        if ($running() === false) {
            $cli->success('Mise à jour automatique arrêtée');
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Mise à jour automatique arrêtée',
                // Recharge le Panel : le bouton « 2. » redevient gris
                'reload'  => true,
            ]);
        } else {
            $cli->error('Impossible d\'arrêter le process sur le port 8080');
            janitor()->data($key, [
                'status'  => 500,
                'message' => 'Impossible d\'arrêter le process (port 8080)',
            ]);
        }
    },
];
