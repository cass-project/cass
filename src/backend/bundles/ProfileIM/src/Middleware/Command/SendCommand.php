<?php
namespace ProfileIM\Middleware\Command;

use ProfileIM\Middleware\Request\SendMessageRequest;
use Psr\Http\Message\ServerRequestInterface;

class SendCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $sendRequest = new SendMessageRequest($request);

        throw new \Exception('Still not implemented');
    }
}