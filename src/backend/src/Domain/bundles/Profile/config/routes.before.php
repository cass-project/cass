<?php
namespace Domain\Profile;

use Domain\Profile\Middleware\WithProfileMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {
    $app->pipe('/protected/with-profile/{profileId}', WithProfileMiddleware::class);
};