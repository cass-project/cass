<?php
namespace Domain\PostReport;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\PostReport\Entity\PostReport;
use Domain\PostReport\Repository\PostReportRepository;

return [
  'php-di' => [
    PostReportRepository::class => \DI\factory(new DoctrineRepositoryFactory(PostReport::class)),
  ]
];
