<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Aura\Auth\Adapter\AdapterInterface;
use Aura\Auth\Auth as AuraAuth;
use Aura\Auth\AuthFactory as AuraFactory;
use Aura\Auth\Service\LoginService;
use Aura\Auth\Service\LogoutService;
use Aura\Auth\Service\ResumeService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthFactory
{
    public function __invoke(ContainerInterface $container, string $name)
    {
        switch ($name) {
            case AuraFactory::class:
                return $this->newFactory();
                break;
            case AdapterInterface::class:
                return $this->newAdapter($container);
                break;
            case LoginService::class:
                return $this->newLoginService($container);
                break;
            case LogoutService::class:
                return $this->newLogoutService($container);
                break;
            case Domain\Login::class:
                return $this->newLogin($container);
                break;
            case Domain\Logout::class:
                return $this->newLogout($container);
                break;
            case ResumeService::class:
                return $this->newResumeService($container);
                break;
            case Middleware\ResumeAuthentication::class:
                return $this->newResumeAuthentication($container);
                break;
            case Middleware\RequireAuthentication::class:
                return $this->newRequireAuthentication($container);
                break;
            case Handle\Authenticated::class:
            case Handle\NotAuthenticated::class:
                return $this->newHandler($container, $name);
                break;
            case Responder::class:
                return $this->newResponder($container);
                break;
            default:
                throw new ServiceNotFoundException($name);
        }
    }

    public function newFactory() : AuraFactory
    {
        return new AuraFactory($_COOKIE);
    }

    public function newAdapter(ContainerInterface $container) : AdapterInterface
    {
        return $container->get(AuraFactory::class)->newHtpasswdAdapter('htpasswd');
    }

    public function newLoginService(ContainerInterface $container) : LoginService
    {
        $adapter = $container->get(AdapterInterface::class);
        return $container->get(AuraFactory::class)->newLoginService($adapter);
    }

    public function newLogoutService(ContainerInterface $container) : LogoutService
    {
        $adapter = $container->get(AdapterInterface::class);
        return $container->get(AuraFactory::class)->newLogoutService($adapter);
    }

    public function newLogin(ContainerInterface $container) : Domain\Login
    {
        return new Domain\Login($container->get(LoginService::class));
    }

    public function newLogout(ContainerInterface $container) : Domain\Logout
    {
        return new Domain\Logout($container->get(LogoutService::class));
    }

    public function newResumeService(ContainerInterface $container) : ResumeService
    {
        return $container->get(AuraFactory::class)
             ->newResumeService(
                 $container->get(AdapterInterface::class),
                 ini_get('session.gc_maxlifetime'),
             );
    }

    public function newResumeAuthentication(ContainerInterface $container) : Middleware\ResumeAuthentication
    {
        return new Middleware\ResumeAuthentication(
            $container->get(AuraAuth::class),
            $container->get(ResumeService::class)
        );
    }

    public function newRequireAuthentication(ContainerInterface $container) : Middleware\RequireAuthentication
    {
        return new Middleware\RequireAuthentication(
            $container->get(Handle\NotAuthenticated::class)
        );
    }

    public function newHandler(ContainerInterface $container, string $name) : RequestHandlerInterface
    {
        return new $name($container->get(ResponseFactoryInterface::class));
    }

    public function newResponder(ContainerInterface $container) : callable
    {
        return new Responder(
            $container->get(Handle\Authenticated::class),
            $container->get(Handle\NotAuthenticated::class)
        );
    }
}
