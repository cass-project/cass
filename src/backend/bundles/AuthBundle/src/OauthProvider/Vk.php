<?php
namespace Auth\OauthProvider;

use \League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

/**
 * User: юзер
 * Date: 15.02.2016
 * Time: 17:03
 * To change this template use File | Settings | File Templates.
 */
class Vk extends AbstractProvider
{
	public function getBaseAuthorizationUrl(){
		return 'https://oauth.vk.com/authorize';
	}

	public function getBaseAccessTokenUrl(array $params){
		return 'https://oauth.vk.com/access_token';
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token){
		$fields = ['email',
							 'nickname',
							 'screen_name',
							 'sex',
							 'bdate',
							 'city',
							 'country',
							 'timezone',
							 'photo_50',
							 'photo_100',
							 'photo_200_orig',
							 'has_mobile',
							 'contacts',
							 'education',
							 'online',
							 'counters',
							 'relation',
							 'last_seen',
							 'status',
							 'can_write_private_message',
							 'can_see_all_posts',
							 'can_see_audio',
							 'can_post',
							 'universities',
							 'schools',
							 'verified', ];
		return "https://api.vk.com/method/users.get?user_id={$token->uid}&fields="
					 .implode(",", $fields)."&access_token={$token}";
	}

	protected function getDefaultScopes(){
		// TODO: Implement getDefaultScopes() method.
	}

	protected function checkResponse(ResponseInterface $response, $data){
		// TODO: Implement checkResponse() method.
	}

	protected function createResourceOwner(array $response, AccessToken $token){
		// TODO: Implement createResourceOwner() method.
	}




}