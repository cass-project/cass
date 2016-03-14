<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 04.03.2016
 * Time: 19:15
 */

namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Channel\Middleware\Request\PutChannelRequest;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Config\Definition\Exception\Exception;

class CreateCommand extends Command
{
	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){
		try {

			$entity = [
				'name'=> 'Это новый канал',
				'description' => 'Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
				'created' => '10.11.2008',
				'updated' => '10.11.2009',
				'status' => 2
			];

			$channelEditorService = $this->getChannelService();


//			$name = $request->getAttribute('name');

//			$credentials = json_decode($request->getBody(), true);
//			$name = $credentials['name'];


//			print_r(json_decode($request->getBody()));
//			die();


			$channel = $channelEditorService->create(
				(new PutChannelRequest($request))->getParameters()
			);

			/*return [
				'id' => $theme->getId(),
				'entity' => [
					$theme->toJSON()
				]
			];*/

//			print_r($channel->getAccountId());
//			die();

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