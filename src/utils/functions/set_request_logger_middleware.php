<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Src\Enums\MonoLoggers;
use Src\Middleware\RequestLoggerMiddleware;

function set_request_logger_middleware()
{
    # code...

    return function (ContainerInterface $container): RequestLoggerMiddleware {
        # code...

        $request_logger = $container->get(
            MonoLoggers::REQUEST_LOGGER
        );

        return new RequestLoggerMiddleware($request_logger);
    };
}
