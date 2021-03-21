<?php

namespace Src\Utils\Functions;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;
use Valitron\Validator as V;

function use_valitron_to_validate_fields_to_rules(ServerRequestInterface $response,  array $fields)
{
    # code...

    $body = $response->getParsedBody();

    $valitron = new V($body);


    $valitron->mapFieldsRules($fields);


    $validation_fails = !$valitron->validate();

    if ($validation_fails) {

        $messages = array_reduce(
            callback: function ($carry, $item) {
                return array_merge($carry, $item);
            },
            array: $valitron->errors(),
            initial: []
        );

        $pad_length = 2;

        $message = implode(
            str_pad(PHP_EOL, $pad_length, "\n", STR_PAD_RIGHT),
            $messages
        );

        throw new HttpUnauthorizedException(
            $response,
            $message
        );
    }
}
