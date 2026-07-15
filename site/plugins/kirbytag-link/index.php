<?php

// Convertit les liens /@/page/UUID → page://UUID avant le rendu KirbyText
// Le tag link natif de Kirby 5 résout ensuite page://UUID en URL réelle.

Kirby::plugin('dlechenne/kirbytag-link', [
    'hooks' => [
        'kirbytags:before' => function (string $text, array $data): string {
            return preg_replace(
                '/\(link:\s*\/@\/page\/([a-z0-9]+)/i',
                '(link: page://$1',
                $text
            );
        }
    ]
]);
