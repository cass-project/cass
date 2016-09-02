<?php
namespace CASS\Domain\Bundles\Feedback;

use function DI\object;
use function DI\factory;
use function DI\get;

use CASS\Application\Bundles\Doctrine2\Factory\DoctrineRepositoryFactory;
use CASS\Domain\Bundles\Feedback\Entity\Feedback;
use CASS\Domain\Bundles\Feedback\Entity\FeedbackResponse;
use CASS\Domain\Bundles\Feedback\Repository\FeedbackRepository;
use CASS\Domain\Bundles\Feedback\Repository\FeedbackResponseRepository;

return [
    'php-di' => [
        FeedbackRepository::class => factory(new DoctrineRepositoryFactory(Feedback::class)),
        FeedbackResponseRepository::class => factory(new DoctrineRepositoryFactory(FeedbackResponse::class))
    ]
];