<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ApiKeyAuthenticator extends AbstractGuardAuthenticator
{
    public function supports(Request $request)
    {
        return $request->headers->has('X-API-KEY');
    }

    public function getCredentials(Request $request)
    {
        return $request->headers->get('X-API-KEY');
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        if ($credentials !== '2878ece33344e4f6d9e1105c0362f0671d9432fb4d997023acb734f4c6e6793a') {
            throw new CustomUserMessageAuthenticationException('Clé API invalide');
        }
        // Retourne un utilisateur "fictif" si tu n'utilises pas d'entité User
        return new \Symfony\Component\Security\Core\User\User('api', null, ['ROLE_API']);
    }

    public function checkCredentials($credentials, $user)
    {
        return $credentials === '2878ece33344e4f6d9e1105c0362f0671d9432fb4d997023acb734f4c6e6793a';
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new Response(
            json_encode(['error' => 'Authentication Failed']),
            401,
            ['Content-Type' => 'application/json']
        );
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new Response(
            json_encode(['error' => 'Authentication Required']),
            401,
            ['Content-Type' => 'application/json']
        );
    }

    public function supportsRememberMe()
    {
        return false;
    }
}