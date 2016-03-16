<?php
/**
 * User: юзер
 * Date: 16.03.2016
 * Time: 16:12
 * To change this template use File | Settings | File Templates.
 */

namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class DeleteCommand extends Command
{
	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){

		try{
			$channelId = $request->getAttribute('channelId');

			if(!$channelId) throw new Exception("Отсутствует chnnelId");

			$this->getChannelService()
				->getChannelRepository()
				->delete($channelId);

			$responseBuilder->setStatusSuccess()->setJson([
																											'channel_deleted' => true
																										]
			);
		}catch (\Exception $e){
			$responseBuilder
				->setStatusNotFound()
				->setError($e)
			;
		}


	}

}