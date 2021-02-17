<?php

declare(strict_types=1);

namespace Jnjxp\Auth;

use Aura\Auth\Adapter\AdapterInterface as AuraAdapter;
use Aura\Auth\Auth as AuraAuth;
use Aura\Auth\AuthFactory as AuraFactory;
use Aura\Auth\Service\LoginService as AuraLogin;
use Aura\Auth\Service\LogoutService as AuraLogout;
use Aura\Auth\Service\ResumeService as AuraResume;
use Interop\Container\ServiceProviderInterface;

class AuthServiceProvider implements ServiceProviderInterface
{

    public function getFactories()
    {
        return [
            AuraAdapter::class                      => AuthFactory::class,
            AuraAuth::class                         => [AuraFactory::class, 'newInstance'],
            AuraFactory::class                      => AuthFactory::class,
            AuraLogin::class                        => AuthFactory::class,
            AuraLogout::class                       => AuthFactory::class,
            AuraResume::class                       => AuthFactory::class,
            Domain\Login::class                     => AuthFactory::class,
            Domain\Logout::class                    => AuthFactory::class,
            Handle\Authenticated::class             => AuthFactory::class,
            Handle\NotAuthenticated::class          => AuthFactory::class,
            Middleware\RequireAuthentication::class => AuthFactory::class,
            Middleware\ResumeAuthentication::class  => AuthFactory::class,
            Responder::class                        => AuthFactory::class
        ];
    }


    public function getExtensions()
    {
        return [];
    }
}
