<?php


namespace Src\Utils\Functions;

use Closure;

function set_error_settings(): Closure
{
    # code...

    return fn () => [
        "displayErrorDetails" => true,
        "logErrors" => true,
        "logErrorDetails" => true,
    ];
}
