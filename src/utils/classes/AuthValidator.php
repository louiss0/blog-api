<?php

namespace Src\Utils\Classes;

use Src\Interfaces\IAuthValidator;

use function Src\Utils\Functions\use_valitron_to_validate_fields_to_rules;

class AuthValidator  implements IAuthValidator
{


    function validateEmail($request): void
    {
        $fields = [
            "email" => ["email", "required"],
        ];

        use_valitron_to_validate_fields_to_rules($request, $fields);
    }

    function validatePasswordAndPasswordConfirm($request): void
    {


        $fields = [
            "password" => [
                "required",
                ["lengthMin", 8],
                ["requiredWith", "password-confirm"],
                ["equals", "password-confirm"]
            ],

            "password-confirm" => [
                "required",
                ["lengthMin", 8]
            ],
        ];


        use_valitron_to_validate_fields_to_rules($request, $fields);
    }

    function validateNameEmailAndPassword($request): void
    {
        $fields = [
            "name" => [
                "required",
                ["different", "password"],
                ["different", "email"]
            ],
            "password" => [
                "required",
                ["lengthMin", 8],
                ["different", "email"]
            ],
            "email" => [
                "email",
                "required",
                ["requiredWith", "password",],
                ["requiredWith", "name",],
            ],
        ];


        use_valitron_to_validate_fields_to_rules($request, $fields);
    }

    public function validateEmailAndPassword($request): void
    {
        $fields = [
            "password" => [
                "required",
                ["lengthMin", 8],
            ],
            "email" => [
                "email",
                "required",
                ["requiredWith", "password"],
            ],
        ];


        use_valitron_to_validate_fields_to_rules($request, $fields);
    }

    function validatePasswordCurrentPasswordAndPasswordConfirm($request): void
    {
        $fields = [
            "password" => [
                "required",
                ["requiredWith", "password-confirm",],
                ["requiredWith", "password-current",],
                ["lengthMin", 8],
            ],
            "password-confirm" => [
                "required",
                ["lengthMin", 8],
                ["equals", "password"]
            ],
            "password-current" => [
                "required",
                ["different", "password",],
                ["different", "password-confirm",]
            ]
        ];

        use_valitron_to_validate_fields_to_rules($request, $fields);
    }
}
