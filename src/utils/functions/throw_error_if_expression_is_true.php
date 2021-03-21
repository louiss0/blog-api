<?php




namespace Src\Utils\Functions;

use Exception;

function throw_error_if_expression_is_true(bool $expression,  Exception $error): void
{
    # code...

    if ($expression) {
        # code...

        throw $error;
    }
}
