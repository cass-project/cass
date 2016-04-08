<?php
namespace Profile\Middleware\Command;


use Psr\Http\Message\ServerRequestInterface;

class ReadCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        return ["entity"=>["Command just created"]];
    }

}