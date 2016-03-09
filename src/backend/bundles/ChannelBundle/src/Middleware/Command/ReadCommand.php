<?php
namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class ReadCommand extends Command
{

	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){

		$service = $this->getChannelService();
		$channels = $service->getChannelRepository()->getChannels();

		$responseBuilder->setStatusSuccess()->setJson([
																										'entities'      => $channels,
																										'channels_read' => true
																									]
		);
	}

}