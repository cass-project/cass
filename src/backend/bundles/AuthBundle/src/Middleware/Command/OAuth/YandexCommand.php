<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\OauthProvider\Yandex;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class YandexCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Yandex($this->getOauth2Config());
    }
}