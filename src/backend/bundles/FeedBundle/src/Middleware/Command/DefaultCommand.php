<?php
namespace Feed\Middleware\Command;

use Psr\Http\Message\ServerRequestInterface;

class DefaultCommand extends Command
{
    private $avalibleFilters = [
        "attachment",
        "author",
        "created"
    ];
    public function run(ServerRequestInterface $request)
    {
        $body = json_decode($request->getBody(), true);
        $filters = array_intersect_key($body, array_flip($this->avalibleFilters));
        /**
         * @DOTO Фильтрация постов по заданным параметрам в $avalibleFilters
         */

        return [];
    }
}
