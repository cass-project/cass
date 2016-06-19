<?php
namespace Domain\Feedback;

use Domain\Feedback\Middleware\FeedbackMiddleware;
use Zend\Expressive\Application;

return function(Application $app){
  $app->put(
    '/feedback/{command:create}',
    FeedbackMiddleware::class,
    'feedback-create'
  );

  $app->delete(
    '/feedback/{feedbackId}/{command:cancel}',
    FeedbackMiddleware::class,
    'feedback-delete'
  );

  $app->get(
    '/feedback/{feedbackId}/{command:has-answer}',
    FeedbackMiddleware::class,
    'feedback-has-answer'
  );

  $app->get(
    '/feedback/{command:without-answer}',
    FeedbackMiddleware::class,
    'feedback-without-answer'
  );

  $app->get(
    '/protected/feedback/{command:all}/offset/{offset}/limit/{limit}',
    FeedbackMiddleware::class,
    'feedback-all-from-user'
  );

};