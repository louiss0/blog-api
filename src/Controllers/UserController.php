<?php

namespace  Src\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Src\Interfaces\ISlimController;


class UserController implements ISlimController
{



    public function getAll(ServerRequestInterface $request, ResponseInterface $response)
    {

        $queryParameters = $request->getQueryParams();


        $body = $response->getBody();




        return $response;
    }

    public function getOne(ResponseInterface $response, int $id)
    {



        return $response;
    }


    public function createOne(ResponseInterface $response)
    {
    }

    public function updateOne(ResponseInterface $response, int $id)
    {
    }

    public function deleteOne(ResponseInterface $response, int $id)
    {
    }
}
