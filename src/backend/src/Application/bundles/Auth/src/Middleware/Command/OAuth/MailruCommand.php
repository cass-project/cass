<?php
namespace Application\Auth\Middleware\Command\OAuth;

use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Middleware\Command\Command;
use Application\Auth\OauthProvider\Mailru;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class MailruCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Mailru($this->getOauth2Config());
    }
}