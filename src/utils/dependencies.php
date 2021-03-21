<?php

use DI\Container;
use Src\Enums\MonoLoggers;
use Src\Enums\DependencyStrings;
use Src\Middleware\RequestLoggerMiddleware;
use Tuupola\Middleware\CorsMiddleware;
use function Src\Utils\Functions\set_block_cipher_class;
use function Src\Utils\Functions\set_error_settings;
use function Src\Utils\Functions\set_lcobucci_config_class;
use function Src\Utils\Functions\set_request_logger;

$container = new Container();

$container->set(
    DependencyStrings::ERROR_SETTINGS,
    set_error_settings()
);

$container->set(
    MonoLoggers::REQUEST_LOGGER,
    set_request_logger()
);

$container->set(
    MonoLoggers::ERROR_LOGGER,
    set_error_logger()
);


$container->set(
    DependencyStrings::LCOBUCCI_CONFIG,
    set_lcobucci_config_class()
);

$container->set(
    CorsMiddleware::class,
    set_cors_middleware()
);

$container->set(
    DependencyStrings::BLOCK_CIPHER,
    set_block_cipher_class()
);

$container->set(
    RequestLoggerMiddleware::class,
    set_request_logger_middleware()
);






























return $container;
