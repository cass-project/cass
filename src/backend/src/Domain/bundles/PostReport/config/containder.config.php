<?php
namespace Domain\PostReport;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;

return [
  'php-di' => [
    PostReportRepository::class => factory(new DoctrineRepositoryFactory(PostReport::class)),
  ]
];
