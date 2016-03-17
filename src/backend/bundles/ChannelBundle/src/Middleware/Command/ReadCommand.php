<?php
namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class ReadCommand extends Command
{

	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){

		$service = $this->getChannelService();

		$response = [];

		if($request->getAttribute('channelId')){

			$channelId = $request->getAttribute('channelId');
			$channel = $service->getChannelRepository()->getChannel($channelId);

			$response = [
				'entity'      	=> $channel,
				'channels_read' => true
			];
		} else {


			$channels = $service->getChannelRepository()->getChannels();
			$response = [
				'entities'      => $channels,
				'channels_read' => true
			];
		}

		$responseBuilder->setStatusSuccess()->setJson($response);
	}

}