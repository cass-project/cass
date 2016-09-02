<?php
namespace CASS\Domain\Auth;

use CASS\Domain\Auth\Middleware\AuthMiddleware;
use CASS\Domain\Auth\Middleware\ProtectedMiddleware;

return [
   'common' => [
       [
           'type'       => 'pipe',
           'url'        => '/auth/{command:sign-up}[/]',
           'middleware' => ProtectedMiddleware::class,
       ],
       [
           'type'       => 'route',
           'method'     => 'put',
           'url'        => '/auth/{command:sign-up}[/]',
           'middleware' => AuthMiddleware::class,
           'name'       => 'auth-sign-up'
       ],
       [
           'type'       => 'route',
           'method'     => 'post',
           'url'        => '/auth/{command:sign-in}[/]',
           'middleware' => AuthMiddleware::class,
           'name'       => 'auth-sign-in'
       ],
       [
           'type'       => 'route',
           'method'     => 'get',
           'url'        => '/auth/{command:oauth}/{provider}[/]',
           'middleware' => AuthMiddleware::class,
           'name'       => 'auth-oauth'
       ],
       [
           'type'       => 'route',
           'method'     => 'get',
           'url'        => '/auth/{command:sign-out}[/]',
           'middleware' => AuthMiddleware::class,
           'name'       => 'auth-sign-out'
       ],
   ]
];