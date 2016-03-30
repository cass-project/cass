<?php
namespace Feed\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class SearchCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $text = $request->getAttribute('text');

        $sphinx = $this->getSphinxService();

        $sphinx->SetMatchMode($sphinx::SPH_MATCH_ALL);

        $sphinx->setLimits(0,100);

        $result = $sphinx->Query($text);

        return ['entities' => $result];
    }
}
