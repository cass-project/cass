<?php
namespace Auth\Middleware\Command\OAuth;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class OdnoklassnikiCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        throw new \Exception('Not implemented');
    }
}