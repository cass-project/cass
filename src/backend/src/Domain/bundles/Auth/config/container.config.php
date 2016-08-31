<?php
namespace Domain\Auth;

use function DI\object;
use function DI\factory;
use function DI\get;

use Domain\Auth\Middleware\AuthMiddleware;
use CASS\Application\Bundles\Frontline\Service\FrontlineService;

$config = [
    'php-di' => []
];

foreach (AuthMiddleware::OAUTH2_PROVIDERS as $provider => $commandClassName) {
    $config['php-di'][$commandClassName] = object()->constructorParameter('oauth2Config', get(sprintf('config.oauth2.%s', $provider)));
}

return $config;