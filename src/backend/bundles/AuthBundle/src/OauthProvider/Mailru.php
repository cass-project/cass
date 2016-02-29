<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 22.02.2016
 * Time: 14:26
 */

namespace Auth\OauthProvider;


use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Mailru extends AbstractProvider
{
	public function getBaseAuthorizationUrl(){
		return 'https://connect.mail.ru/oauth/authorize';
	}

	public function getBaseAccessTokenUrl(array $params){
		return 'https://connect.mail.ru/oauth/token';
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token){
		$user = new User();
		$res = $response[0];
		$user->uid = $res->uid;
		$user->email = $res->email;
		$user->firstName = $res->first_name;
		$user->lastName = $res->last_name;
		$user->name = $user->firstName.' '.$user->lastName;
		$user->gender = $res->sex?'female':'male';
		$user->urls = $res->link;
		if (isset($res->location)) {
			$user->location = $res->location->city->name;
		}
		if ($res->has_pic) {
			$user->imageUrl = $res->pic;
		}
		return $user;
	}

	protected function getDefaultScopes(){
	}

	protected function checkResponse(ResponseInterface $response, $data){
	}

	protected function createResourceOwner(array $response, AccessToken $token){
	}

}