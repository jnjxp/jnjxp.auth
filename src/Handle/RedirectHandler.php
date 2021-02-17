<?php

declare(strict_types=1);

namespace Jnjxp\Auth\Handle;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Fig\Http\Message\StatusCodeInterface;

class RedirectHandler implements RequestHandlerInterface, StatusCodeInterface
{
    protected $responseFactory;

    protected $location;

    public function __construct(ResponseFactoryInterface $responseFactory, $location)
    {
        $this->responseFactory = $responseFactory;
        $this->location = $location;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->redirect($this->location);
    }

    protected function redirect($location) : ResponseInterface
    {
        return $this->responseFactory
            ->createResponse(self::STATUS_SEE_OTHER)
            ->withHeader('Location', $location);
    }
}
