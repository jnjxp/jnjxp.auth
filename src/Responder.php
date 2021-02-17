<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Responder
{
    use IsAuthenticatedTrait;

    protected $authenticated;
    protected $notAuthenticated;

    public function __construct(
        RequestHandlerInterface $authenticated,
        RequestHandlerInterface $notAuthenticated
    ) {
        $this->authenticated = $authenticated;
        $this->notAuthenticated = $notAuthenticated;
    }

    public function __invoke(ServerRequestInterface $request) : ResponseInterface
    {
        $handler = $this->isAuthenticated($request)
            ? $this->authenticated
            : $this->notAuthenticated;

        return $handler->handle($request);
    }
}
