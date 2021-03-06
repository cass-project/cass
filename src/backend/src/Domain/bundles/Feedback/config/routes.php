<?php
namespace CASS\Domain\Bundles\Feedback;

use CASS\Domain\Bundles\Feedback\Middleware\FeedbackMiddleware;

return [
    'common' => [
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/feedback/{command:create}[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'put',
            'url'        => '/protected/{command:feedback-response}/create[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-response-create'
        ],
        [
            'type'       => 'route',
            'method'     => 'delete',
            'url'        => '/protected/feedback/{feedbackId}/{command:cancel}[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-delete'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/feedback/{feedbackId}/{command:get}[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-get'
        ],
        [
            'type'       => 'route',
            'method'     => 'get',
            'url'        => '/protected/feedback/{command:list}/offset/{offset}/limit/{limit}[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-list'
        ],
        [
            'type'       => 'route',
            'method'     => 'post',
            'url'        => '/protected/feedback/{feedbackId}/{command:mark-as-read}[/]',
            'middleware' => FeedbackMiddleware::class,
            'name'       => 'feedback-mark-as-read'
        ],
    ]
];