<?php

namespace Src\Utils\Functions;

use Closure;
use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\Key\Derivation\Pbkdf2;
use Laminas\Crypt\Symmetric\Openssl;
use Laminas\Math\Rand;

function set_block_cipher_class(): Closure
{
    # code...

    return function (): BlockCipher {
        # code...
        $hash_algorithm = hash_algos()[5];

        $pass_phrase = $_ENV["CRYPTO_PASSPHRASE"];

        $byte_length = 32;

        $iterations = 10000;

        $salt = Rand::getBytes($byte_length);

        $key  = Pbkdf2::calc($hash_algorithm, $pass_phrase, $salt, $iterations, $byte_length);

        $blockCipher = new  BlockCipher(new Openssl(['algo' => 'aes']));

        return $blockCipher->setKey($key);
    };
}
