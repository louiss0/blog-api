<?php

use Psr\Container\ContainerInterface;
use Src\Enums\MonoLoggers;
use Tuupola\Middleware\CorsMiddleware;

function set_cors_middleware(): Closure
{
    # code...
    return function (ContainerInterface $container): CorsMiddleware {
        # code...


        $logger = $container
            ->get(MonoLoggers::REQUEST_LOGGER)
            ->withName(MonoLoggers::CORS_LOGGER);

        $settings = [
            "origin" => ["*"],
            "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
            "headers.expose" => ["Etag"],
            "credentials" => true,
            "cache" => 86400,
            "logger" => $logger
        ];

        return new CorsMiddleware(
            $settings
        );
    };
}
