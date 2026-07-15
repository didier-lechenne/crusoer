<?php

use Bnomei\Janitor;
use JR\StaticSiteGenerator;
use Kirby\CLI\CLI;
use Kirby\Filesystem\F;

return [
    'description' => 'Generate static site',
    'args' => [] + Janitor::ARGS,
    'command' => static function (CLI $cli): void {
        set_time_limit(0);
        $_SERVER['KIRBY_STATIC_BUILD'] = true;

        $list  = StaticSiteGenerator::generateFromConfig($cli->kirby());
        $count = count($list);

        $cli->success("$count files generated");

        janitor()->data($cli->arg('command'), [
            'status'  => 200,
            'message' => "$count fichiers générés",
        ]);
    }
];
