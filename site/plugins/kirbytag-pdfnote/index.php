<?php

Kirby::plugin('dlechenne/kirbytag-pdfnote', [
    'fabianmichael.markdown-field.customHighlights' => [
        [
            'name'  => 'pdfnote',
            'regex' => '\(pdfnote\s*:\s*[^)]*\)',
            'class' => 'cm-footnote-full',
        ]
    ],
    'tags' => [
        'pdfnote' => [
            'attr' => ['caption', 'class'],
            'html' => function ($tag) {
                $value      = trim((string)($tag->value() ?? ''));
                $caption    = trim((string)($tag->caption() ?? ''));
                $class      = trim((string)($tag->class() ?? ''));
                $captionHtml = '';

                if ($value === '') {
                    return '';
                }

                // Résolution du fichier PDF Kirby (avec ou sans extension)
                $pdfFile = $tag->file($value)
                        ?? $tag->file($value . '.pdf');
                $src     = $pdfFile ? $pdfFile->url() : $value;

                // Fallback sur la légende du fichier si aucun attribut caption
                if ($caption !== '') {
                    $captionHtml = kirbytextinline($caption);
                } elseif ($pdfFile && $pdfFile->caption()->isNotEmpty()) {
                    $raw         = (string)$pdfFile->caption()->value();
                    $captionHtml = preg_replace('/<\/p>\s*<p[^>]*>/', '<br>', $raw);
                    $captionHtml = preg_replace('/<\/?p[^>]*>/', '', $captionHtml);
                    $caption     = strip_tags($captionHtml);
                }

                // Génère l'id depuis le nom de fichier : sans extension, _ et espaces → -
                $filename = pathinfo($value, PATHINFO_FILENAME);
                $id       = strtolower(preg_replace('/[\s_]+/', '-', $filename));

                // Récupération du cover depuis les métadonnées du fichier PDF
                $coverFile = $pdfFile ? $pdfFile->cover()->toFile() : null;

                $figcaption = $captionHtml !== ''
                    ? '<span class="figcaption">' . $captionHtml . '</span>'
                    : '';

                if ($coverFile) {
                    $alt   = $caption !== '' ? htmlspecialchars(strip_tags($caption)) : htmlspecialchars((string)$coverFile->alt());
                    $inner = '<img src="' . $coverFile->resize(400)->url() . '" alt="' . $alt . '">';
                    $link  = '<a href="' . $src . '" data-lightbox="pdf" class="pdfnote__trigger">' . $inner . '</a>';
                } else {
                    $inner = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 4H15V8H19V20H5V4ZM3.9985 2C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H20.0066C20.5551 22 21 21.5489 21 20.9925L20.9997 7L16 2H3.9985ZM10.4999 7.5C10.4999 9.07749 10.0442 10.9373 9.27493 12.6534C8.50287 14.3757 7.46143 15.8502 6.37524 16.7191L7.55464 18.3321C10.4821 16.3804 13.7233 15.0421 16.8585 15.49L17.3162 13.5513C14.6435 12.6604 12.4999 9.98994 12.4999 7.5H10.4999ZM11.0999 13.4716C11.3673 12.8752 11.6042 12.2563 11.8037 11.6285C12.2753 12.3531 12.8553 13.0182 13.5101 13.5953C12.5283 13.7711 11.5665 14.0596 10.6352 14.4276C10.7999 14.1143 10.9551 13.7948 11.0999 13.4716Z"></path></svg>';
                    $link  = '<a href="' . $src . '" data-lightbox="pdf" class="pdfnote__trigger">' . $inner . '</a>';
                }

                $classes = trim('pdfnote sn-note figure ' . $class);
                return '<span data-type="pdfnote" id="' . $id . '" class="' . $classes . '">' . $link . $figcaption . '</span>';
            }
        ]
    ]
]);
