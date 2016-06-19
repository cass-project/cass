<?php
namespace Domain\Feedback;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Repository\FeedbackRepository;
use \DI\factory;

return [
  'php-di' => [
    FeedbackRepository::class => factory(new DoctrineRepositoryFactory(Feedback::class)),
  ]
];