<?php
namespace Domain\Feedback;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Repository\FeedbackRepository;

return [
  'php-di' => [
    FeedbackRepository::class => \DI\factory(new DoctrineRepositoryFactory(Feedback::class))
  ]
];