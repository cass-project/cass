<?php
namespace Application\Auth\Middleware\Command\OAuth;

use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Auth\Middleware\Command\Command;
use Application\Auth\OauthProvider\Vk;
use Application\Auth\Service\AuthService\Exceptions\DuplicateAccountException;
use Application\Auth\Service\AuthService\Exceptions\MissingReqiuredFieldException;
use Application\Auth\Service\AuthService\Exceptions\ValidationException;
use Application\Account\Entity\Account;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Diactoros\ServerRequest;
use Application\Auth\Service\AuthService\Exceptions\DuplicateAccountExeption;

class VkCommand extends AbstractCommand
{
    protected function getOAuth2Provider(): AbstractProvider
    {
        return new Vk($this->getOauth2Config());
    }
}