<?php
namespace Auth\Middleware\Command\OAuth;

use Common\REST\GenericRESTResponseBuilder;
use Auth\Middleware\Command\Command;
use Auth\OauthProvider\Vk;
use Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Auth\Service\AuthService\Exceptions\ValidationException;
use Account\Entity\Account;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Diactoros\ServerRequest;
use Auth\Service\AuthService\Exceptions\DuplicateAccountExeption;

class VkCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Vk($this->getOauth2Config());
    }
}