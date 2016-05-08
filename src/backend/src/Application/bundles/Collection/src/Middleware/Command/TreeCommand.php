<?php
namespace Application\Collection\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class TreeCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $entities = $this->getCollectionService()
            ->read([
                "profile" => $request->getAttribute("profileId")
            ],true);

        return ['entities'=> $entities];
    }
}