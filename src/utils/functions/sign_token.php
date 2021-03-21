<?php

namespace Src\Utils\Functions;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;

function sign_token(
    Configuration $configuration,
    $user,
    DateTimeImmutable $now,
    DateTimeImmutable $expires_at
): string {
    # code...

    extract($user);


    $key = $configuration->signingKey();

    $signer = $configuration->signer();

    return $configuration
        ->builder()
        ->withClaim("email", $email)
        ->withClaim("id", $id)
        ->withClaim("role", $role)
        ->issuedAt($now)
        ->expiresAt($expires_at)
        ->getToken($signer, $key)
        ->toString();
}
