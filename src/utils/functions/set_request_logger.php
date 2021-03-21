<?php


namespace Src\Utils\Functions;

use Closure;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Src\Enums\MonoLoggers;

function set_request_logger(): Closure
{
    # code...
    return function () {
        # code...

        $logger = new Logger(MonoLoggers::REQUEST_LOGGER);

        $logger
            ->pushProcessor(new UidProcessor())
            ->setHandlers(
                [
                    new StreamHandler(__DIR__  . "/../../logs/app-log.php",),
                    new FirePHPHandler()

                ]
            );


        return $logger;
    };
}
