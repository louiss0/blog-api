<?php

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/routes/index.php';
require __DIR__ . '/utils/functions.php';
$container = require __DIR__ . '/utils/dependencies.php';

use \DI\Bridge\Slim\Bridge;

use function Src\Utils\Functions\set_global_middleware;

use function Src\Utils\Functions\set_routes;


$app = Bridge::create($container);


set_global_middleware($app);

set_routes($app);



$app->run();
