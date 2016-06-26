<?php
namespace Domain\Feedback;

use function DI\object;
use function DI\factory;
use function DI\get;

use Application\Doctrine2\Factory\DoctrineRepositoryFactory;
use Domain\Feedback\Entity\Feedback;
use Domain\Feedback\Entity\FeedbackResponse;
use Domain\Feedback\Repository\FeedbackRepository;
use Domain\Feedback\Repository\FeedbackResponseRepository;

return [
    'php-di' => [
        FeedbackRepository::class => factory(new DoctrineRepositoryFactory(Feedback::class)),
        FeedbackResponseRepository::class => factory(new DoctrineRepositoryFactory(FeedbackResponse::class))
    ]
];