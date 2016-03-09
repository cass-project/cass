<?php
namespace Auth\Middleware\Command\OAuth;

use Application\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use League\OAuth2\Client\Provider\AbstractProvider;
use Psr\Http\Message\ServerRequestInterface;

class FacebookCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        throw new \Exception('Not implemented');
    }
}