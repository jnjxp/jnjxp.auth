<?php

declare(strict_types=1);

namespace Jnjxp\Auth\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Jnjxp\Auth\IsAuthenticatedTrait;

class RequireAuthentication implements MiddlewareInterface
{
    use IsAuthenticatedTrait;

    protected $notAuthenticated;

    public function __construct(RequestHandlerInterface $notAuthenticated)
    {
        $this->notAuthenticated = $notAuthenticated;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $handler = $this->isAuthenticated($request) ? $handler : $this->notAuthenticated;
        return $handler->handle($request);
    }
}
