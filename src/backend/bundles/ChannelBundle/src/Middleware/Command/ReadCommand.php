<?php
namespace Channel\Middleware\Command;


use Application\REST\GenericRESTResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

class ReadCommand extends Command
{

	public function run(ServerRequestInterface $request, GenericRESTResponseBuilder $responseBuilder){


		$entity = [
			'name'=> 'Это новый канал',
			'description' => 'Наш канал создан исключительно в развлекательных целях и не имеет цель оскорбить или опорочить кого либо. Наши ролики создаются в жанре литературной, музыкальной или иной пародии,в жанре карикатуры на основе другого (оригинального) правомерно обнародованного произведения.',
			'created' => '10.11.2008',
			'updated' => '10.11.2009',
			'status' => 2
		];

		$entities=[];
		for($i=0;$i<30;$i++){
			$entity['id']=$i;

			$entities[] = $entity;
		}

		$responseBuilder->setStatusSuccess()->setJson([
																										'entities'          => $entities,
																										'channels_read' => true
																									]
		);
	}

}