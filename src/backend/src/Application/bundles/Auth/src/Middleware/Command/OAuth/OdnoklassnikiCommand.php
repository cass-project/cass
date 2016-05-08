<?php
namespace Application\Auth\Middleware\Command\OAuth;

use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Middleware\Command\Command;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class OdnoklassnikiCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        throw new \Exception('Not implemented');
    }
}