<?php

use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Src\Enums\MonoLoggers;

function set_error_logger(): Closure
{
    # code...

    return function (ContainerInterface $container) {
        # code...

        $error_logger = $container->get(
            MonoLoggers::REQUEST_LOGGER
        )->withName(
            MonoLoggers::ERROR_LOGGER
        );

        $error_logger->toMonologLevel(Logger::ERROR);

        return $error_logger;
    };
}
