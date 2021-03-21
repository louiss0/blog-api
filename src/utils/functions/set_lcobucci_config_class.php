<?php

namespace Src\Utils\Functions;

use Closure;
use DateTimeImmutable;
use Lcobucci\Clock\FrozenClock;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\StrictValidAt;
use Lcobucci\JWT\Signer\Hmac\Sha256;

function set_lcobucci_config_class(): Closure
{
    # code...

    return function (): Configuration {
        # code...

        $key = InMemory::base64Encoded("a29m4ml3ZW1vb21jbHBwZG9lbWs=");
        $signer = new Sha256();
        $clock = new FrozenClock(new DateTimeImmutable());

        $constraints = [
            new StrictValidAt($clock),
            new SignedWith($signer, $key),
        ];


        $config = Configuration::forSymmetricSigner(
            $signer,
            $key

        );


        $config->setValidationConstraints(
            ...$constraints
        );

        return $config;
    };
}
