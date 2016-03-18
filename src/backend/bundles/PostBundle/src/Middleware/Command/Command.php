<?php
/**
 * User: юзер
 * Date: 18.03.2016
 * Time: 15:19
 * To change this template use File | Settings | File Templates.
 */

namespace Post\Middleware\Command;


use Application\REST\Exceptions\UnknownActionException;
use Psr\Http\Message\ServerRequestInterface;

class Command
{
	static public function factory(ServerRequestInterface $request)
	{
		$action = $request->getAttribute('command');

		switch ($action) {
			case 'create':
				return new CreateCommand();
			break;
			case 'read':
				return new ReadCommand();
			break;
			case 'update':
				return new UpdateCommand();
			break;
			case 'delete':
				return new DeleteCommand();
			break;

		}


		throw new UnknownActionException('Unknown action');
	}
}