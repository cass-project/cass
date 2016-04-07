<?php
namespace Feed\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class SearchCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
        $sphinx      = $this->getSphinxClient();
        $queryParams = $request->getQueryParams();
        $text     = $request->getAttribute('text');
        $limit    = $queryParams["limit"] ?? $sphinx->limit;
        $page     = $queryParams["page"]  ?? 1;
        /**
         * @DOTO maxLimit via sharedConfigService
        $sharedConfigService = $container->get(SharedConfigService::class);
        $config = $sharedConfigService->get('seatch');
         */
        $maxLimit = 150;
        $limit    = min([$maxLimit, $limit]);
        $offset   = ($page-1) * $limit;

        $sphinx->SetMatchMode($sphinx::SPH_MATCH_ALL);
        $sphinx->setLimits($offset, $limit);
        return $sphinx->Query(urldecode($text));
    }
}
