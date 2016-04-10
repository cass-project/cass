<?php
namespace Auth\Middleware\Command\OAuth;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\OauthProvider\Mailru;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class MailruCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Mailru($this->getOauth2Config());
    }
}