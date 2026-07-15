<?php

Kirby::plugin('dlechenne/kirbytag-imagenote', [
    'fabianmichael.markdown-field.customHighlights' => [
        [
            'name'  => 'imagenote',
            'regex' => '\(imagenote\s*:\s*[^)]*\)',
            'class' => 'cm-footnote-full',
        ]
    ],
    'tags' => [
        'imagenote' => [
            'attr' => ['caption', 'class'],
            'html' => function ($tag) {
                $value   = trim((string)($tag->value() ?? ''));
                $caption = trim((string)($tag->caption() ?? ''));
                $class   = trim((string)($tag->class() ?? ''));

                if ($value === '') {
                    return '';
                }

                // Résolution du fichier Kirby (image uploadée via le panel)
                $file = $tag->file($value);
                $src  = $file ? $file->url() : $value;

                // Génère l'id depuis le nom de fichier : sans extension, _ et espaces → -
                $filename = pathinfo($value, PATHINFO_FILENAME);
                $id       = strtolower(preg_replace('/[\s_]+/', '-', $filename));

                // Fallback sur la légende du fichier si aucun attribut caption
                if ($caption === '' && $file) {
                    $caption = trim((string)($file->caption()->value() ?? ''));
                }

                $alt        = $caption !== '' ? htmlspecialchars(strip_tags($caption)) : ($file ? htmlspecialchars((string)$file->alt()) : '');
                $img        = $file
                    ? '<img src="' . $file->resize(400)->url() . '" srcset="' . $file->srcset('default') . '" alt="' . $alt . '">'
                    : '<img src="' . $src . '" alt="' . $alt . '">';
                // Lightbox : miniature 2400 px (webp via la config thumbs), pas l'original
                $href       = $file ? $file->resize(2400)->url() : $src;
                $link       = '<a href="' . $href . '" data-lightbox="imagenote">' . $img . '</a>';

                $figcaption = $caption !== ''
                    ? '<span class="figcaption">' . kirbytextinline($caption) . '</span>'
                    : '';

                $classes = 'imagenote sn-note figure' . ($class !== '' ? ' ' . htmlspecialchars($class) : '');
                return '<span data-type="imagenote" id="' . $id . '" class="' . $classes . '">' . $link . $figcaption . '</span>';
            }
        ]
    ]
]);
