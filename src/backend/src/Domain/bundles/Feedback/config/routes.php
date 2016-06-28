<?php
namespace Domain\Feedback;

use Domain\Feedback\Middleware\FeedbackMiddleware;
use Zend\Expressive\Application;

return function(Application $app) {
    $app->put(
        '/feedback/{command:create}',
        FeedbackMiddleware::class,
        'feedback-create'
    );
    $app->put(
        '/{command:feedback-response}/create',
        FeedbackMiddleware::class,
        'feedback-response-create'
    );

    $app->delete(
        '/feedback/{feedbackId}/{command:cancel}',
        FeedbackMiddleware::class,
        'feedback-delete'
    );

    $app->get(
        '/protected/feedback/{command:list}/offset/{offset}/limit/{limit}',
        FeedbackMiddleware::class,
        'feedback-list'
    );
};