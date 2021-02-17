<?php

declare(strict_types = 1);

namespace Jnjxp\Auth\Middleware;

use Aura\Auth\Auth;
use Aura\Auth\Service\ResumeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ResumeAuthentication implements MiddlewareInterface
{
    private $auth;
    private $resume;

    public function __construct(Auth $auth, ResumeService $resume)
    {
        $this->auth = $auth;
        $this->resume = $resume;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->withAuthentication($request);
        return $handler->handle($request);
    }

    protected function withAuthentication(ServerRequestInterface $request) : ServerRequestInterface
    {
        $this->resumeAuth();
        return $request->withAttribute(Auth::class, $this->auth);
    }

    protected function resumeAuth() : void
    {
        $this->resume->resume($this->auth);
    }
}
