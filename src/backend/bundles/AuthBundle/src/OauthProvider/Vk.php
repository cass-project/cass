<?php
namespace Auth\OauthProvider;

use League\OAuth2\Client\Grant\AbstractGrant;
use \League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;

class Vk extends AbstractProvider
{
	public $user_id;
	public $user_email;

	public function getBaseAuthorizationUrl(){
		return 'https://oauth.vk.com/authorize';
	}

	public function getBaseAccessTokenUrl(array $params){
		return 'https://oauth.vk.com/access_token';
	}

	public function getResourceOwnerDetailsUrl(AccessToken $token){
		$fields = $this->requestFields();

		return "https://api.vk.com/method/users.get?user_id={$token->getResourceOwnerId()}&fields="
					 .implode(",", $fields)."&access_token={$token}&scope=email";
	}

	protected function createAccessToken(array $response, AbstractGrant $grant)
	{
		$this->user_id = $response['user_id'] ?? null;
		$this->user_email = $response['user_email'] ?? null;

		$response['resource_owner_id'] = $this->user_id;

		return new AccessToken($response);
	}

	protected function getDefaultScopes(){
	}

	protected function checkResponse(ResponseInterface $response, $data){
		//return parent::checkResponse($response,$data);
	}

	protected function createResourceOwner(array $response, AccessToken $token){
	}

	/**
	 * @return array
	 */
	private function requestFields()
	{
		$fields = [
			'email',
			'nickname',
			'screen_name',
			'sex',
			'timezone',
			'photo_50',
			'photo_100',
			'photo_200_orig'
		];
		return $fields;
	}
}