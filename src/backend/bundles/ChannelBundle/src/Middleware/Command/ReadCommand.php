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
				'success' => true,
				'entity'  => $channel,
			];
		} else {

			$channels = $service->getChannelRepository()->getChannels();
			$response = [
				'success' 	=> true,
				'total'			=> count($channels),
				'entities'  => $channels,
			];
		}

		$responseBuilder->setStatusSuccess()->setJson($response);
	}

}