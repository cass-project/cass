<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 04.03.2016
 * Time: 19:15
 */

namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Application\Tools\RequestParams\Param;
use Channel\Middleware\Request\PutChannelRequest;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateCommand extends Command
{
	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){
		try {

			$channelEditorService = $this->getChannelService();

			$account = $this->getCurrentProfileService()->getCurrentAccount();

			$accountIdParam = new Param(['account_id'=>$account->getId()], 'account_id');

			$channel = $channelEditorService->create(
				(new PutChannelRequest($request))->getParameters()->setAccountId($accountIdParam)
			);


			$responseBuilder->setStatusSuccess()->setJson([
																											'entity'          => $channel->toJSON(),
																											'channel_created' => true
																										]
			);
		} catch (Exception $e) {
			$responseBuilder
				->setStatusNotFound()
				->setError($e)
			;
		}
	}

}