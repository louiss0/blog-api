<?php

namespace Src\Routes;

use Lcobucci\JWT\Configuration;
use Slim\Routing\RouteCollectorProxy;
use Src\Controllers\UserController;
use Src\Enums\Paths;
use Src\Enums\DependencyStrings;
use Src\Middleware\AuthMiddleware;
use Src\Middleware\RouteRestrictionMiddleware;

function user_router(RouteCollectorProxy $group)
{

    # code...

    $container = $group->getContainer();

    $group->group(
        Paths::USERS,
        function (RouteCollectorProxy $group) {
            # code...

            $group->get("", [UserController::class, UserController::GET_ALL]);

            $group->post("", [UserController::class, UserController::CREATE_ONE]);

            $group->patch("/{id}", [UserController::class, UserController::UPDATE_ONE]);

            $group->get("/{id}", [UserController::class, UserController::GET_ONE]);

            $group->delete("/{id}", [UserController::class, UserController::DELETE_ONE]);
        }
    )->addMiddleware(new RouteRestrictionMiddleware($container))
        ->addMiddleware(new AuthMiddleware($container));
}
