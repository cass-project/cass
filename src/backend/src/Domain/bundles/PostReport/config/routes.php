<?php
namespace Domain\PostReport;

use Domain\PostReport\Middleware\PostReportMiddleware;
use Zend\Expressive\Application;

return function (Application $app) {

  $app->put(
    '/protected/post-report/{command:create}',
    PostReportMiddleware::class,
    'post-report-create'
  );

  $app->get(
    '/protected/post-report/{command:list}/type/{type}/offset/{offset}/limit/{limit}/',
    PostReportMiddleware::class,
    'post-report-list'
  );

};
