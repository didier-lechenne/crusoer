<?php

Kirby::plugin('dlechenne/kirbytag-inlinenote', [
    'tags' => [
        'note' => [
            'html' => function ($tag) {
                $text = trim((string)($tag->value() ?? ''));

                if ($text === '') {
                    return '';
                }

                $page = $tag->parent();
                $class = $page?->notes_print()->value() ?: 'inline-note';

                return '<span class="' . $class . '">' . $text . '</span>';
            }
        ]
    ],
    'hooks' => [
        'kirbytags:before' => function ($text, array $data): string {
            if (!is_string($text)) {
                return (string)$text;
            }

            // Normalise typographie française : (note : → (note:
            $text = preg_replace('/\(note\s+:\s*/', '(note: ', $text);

            // Récupère la classe depuis notes_print
            $page = $data['parent'] ?? null;
            $class = $page?->notes_print()->value() ?: 'inline-note';

            // ^[texte] → <span>
            $text = preg_replace_callback('/\^\[([^\]]+)\]/', function ($m) use ($class) {
                return '<span class="' . $class . '">' . $m[1] . '</span>';
            }, $text);

            // [^texte] (non suivi de :) → <span>
            $text = preg_replace_callback('/\[\^([^\]]+)\](?!:)/', function ($m) use ($class) {
                return '<span class="' . $class . '">' . $m[1] . '</span>';
            }, $text);

            return $text;
        }
    ]
]);
