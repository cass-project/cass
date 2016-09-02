<?php
namespace CASS\Domain\Bundles\IM;

use CASS\Domain\Bundles\IM\Middleware\ProfileIMMiddleware;

return [
  'common' => [
      [
          'type'       => 'route',
          'method'     => 'put',
          'url'        => '/protected/with-profile/{sourceProfileId}/im/{command:send}/to/{source}/{sourceId}[/]',
          'middleware' => ProfileIMMiddleware::class,
          'name'       => 'profile-im-send'
      ],
      [
          'type'       => 'route',
          'method'     => 'get',
          'url'        => '/protected/with-profile/{targetProfileId}/im/{command:unread}[/]',
          'middleware' => ProfileIMMiddleware::class,
          'name'       => 'profile-im-unread'
      ],
      [
          'type'       => 'route',
          'method'     => 'post',
          'url'        => '/protected/with-profile/{targetProfileId}/im/{command:messages}/{source}/{sourceId}[/]',
          'middleware' => ProfileIMMiddleware::class,
          'name'       => 'profile-im-messages'
      ],
  ]
];