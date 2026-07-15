<?php

use Bnomei\Janitor;
use Kirby\CLI\CLI;

/**
 * Met à jour Kirby vers la dernière version publiée (même version majeure).
 * Le dossier kirby/ doit être un clone git (cf. README « Mettre à jour Kirby »).
 * Bouton Panel (Janitor) ou : php vendor/bin/kirby update-kirby
 */
return [
    'description' => 'Update Kirby to the latest release of the current major version',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        set_time_limit(0);

        $key     = (string) $cli->arg('command');
        $dir     = kirby()->root('kirby');
        $current = kirby()->version();
        $major   = explode('.', $current)[0];

        $fail = static function (string $message) use ($cli, $key): void {
            $cli->error($message);
            janitor()->data($key, ['status' => 500, 'message' => $message]);
        };

        if (is_dir($dir . '/.git') === false) {
            $fail('kirby/ n\'est pas un clone git : mise à jour manuelle requise (voir README)');
            return;
        }

        $git = 'git -C ' . escapeshellarg($dir) . ' ';

        // Dernière version publiée de la même version majeure
        exec($git . 'ls-remote --tags origin 2>&1', $out, $code);
        if ($code !== 0) {
            $fail('git ls-remote a échoué : ' . implode(' | ', array_slice($out, -2)));
            return;
        }

        $versions = [];
        foreach ($out as $line) {
            if (preg_match('!refs/tags/(' . $major . '\.\d+\.\d+)$!', $line, $m)) {
                $versions[] = $m[1];
            }
        }

        if ($versions === []) {
            $fail('Aucune version ' . $major . '.x trouvée sur le dépôt distant');
            return;
        }

        usort($versions, 'version_compare');
        $latest = end($versions);

        if (version_compare($latest, $current, '<=')) {
            $cli->success('Kirby déjà à jour (' . $current . ')');
            janitor()->data($key, [
                'status'  => 200,
                'message' => 'Kirby déjà à jour (' . $current . ')',
            ]);
            return;
        }

        // Le clone peut être shallow (--depth 1) : on récupère uniquement le tag visé
        exec($git . 'fetch --depth 1 origin tag ' . escapeshellarg($latest) . ' 2>&1', $fetchOut, $code);
        if ($code !== 0) {
            $fail('git fetch a échoué : ' . implode(' | ', array_slice($fetchOut, -2)));
            return;
        }

        exec($git . 'checkout ' . escapeshellarg($latest) . ' 2>&1', $checkoutOut, $code);
        if ($code !== 0) {
            $fail('git checkout a échoué : ' . implode(' | ', array_slice($checkoutOut, -2)));
            return;
        }

        $message = 'Kirby mis à jour : ' . $current . ' → ' . $latest;
        $cli->success($message);
        janitor()->data($key, [
            'status'  => 200,
            'message' => $message,
        ]);
    },
];
