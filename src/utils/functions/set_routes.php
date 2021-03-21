<?php

namespace Src\Utils\Functions;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Src\Enums\Paths;

use function Src\Routes\auth_router;
use function Src\Routes\user_router;

function set_routes(App $app)
{
    # code...

    $app->group(
        Paths::API_VERSION,
        function (RouteCollectorProxy $group) {
            # code...

            user_router($group);

            auth_router($group);
        }
    );
}
