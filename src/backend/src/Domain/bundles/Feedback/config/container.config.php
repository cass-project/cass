<?php
namespace Domain\Feedback;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Repository\FeedbackRepository;
use Domain\Feedback\Repository\FeedbackResponseRepository;

return [
  'php-di' => [
    FeedbackRepository::class => \DI\factory(new DoctrineRepositoryFactory(Feedback::class)),
    FeedbackResponseRepository::class => \DI\factory(new DoctrineRepositoryFactory(FeedbackResponse::class))
  ]
];