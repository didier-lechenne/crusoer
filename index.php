<?php

require __DIR__ . '/kirby/vendor/autoload.php';
require __DIR__ . '/kirby/bootstrap.php';

echo (new Kirby\Cms\App())->render();
