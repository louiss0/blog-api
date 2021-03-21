<?php

namespace Src\Utils\Functions;

/** 

@param string $name  

@param int $number_of_days  

@param string $php_env  The php env variable either development or production  

 */
function send_secure_cookie(
    string $name,
    int $number_of_days,
    string $php_env,
) {
    # code...
    $one_day = 24 * 60 ** 2 * 1000;

    $expires = time()  * $one_day + $number_of_days;

    $cookieOptions = [
        "secure" => false,
        "httpOnly" => true,
        "expires" => $expires,
    ];

    if ($php_env === "production") {

        $cookieOptions["secure"] = true;

        return setcookie(
            name: $name,
            options: $cookieOptions
        );
    }

    setcookie(name: $name, options: $cookieOptions);
}
