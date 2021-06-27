<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

abstract class Controller extends AbstractFOSRestController
{
    final public function response($data, int $statusCode = Response::HTTP_OK): Response
    {
        return $this->handleView($this->view($data, $statusCode));
    }
}
