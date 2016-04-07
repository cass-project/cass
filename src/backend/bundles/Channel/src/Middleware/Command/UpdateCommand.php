<?php
/**
 * User: юзер
 * Date: 16.03.2016
 * Time: 16:27
 * To change this template use File | Settings | File Templates.
 */

namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Channel\Middleware\Request\UpdateChannelRequest;
use Channel\Service\ChannelService;
use Psr\Http\Message\ServerRequestInterface;

class UpdateCommand extends Command
{
	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){
		try{
			/** @var ChannelService $channelService */
			$channelService = $this->getChannelService();

			$channelEntity = $channelService->update((new UpdateChannelRequest($request))->getParameters());

			$responseBuilder->setStatusSuccess()->setJson($channelEntity->toJSON());

		}catch (\Exception $e){
			$responseBuilder
				->setStatusNotFound()
				->setError($e);
		}
	}

}