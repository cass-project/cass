<?php
namespace Application\Collection\Middleware\Request;

use Application\Collection\Service\Parameters\CollectionService\CollectionDeleteParameters;
use Common\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class CollectionDeleteRequest extends RequestParams
{
    public function generateParams(ServerRequestInterface $request)
    {
        $colletionId = (int) $request->getAttribute('collectionId');

        return new CollectionDeleteParameters($colletionId);
    }
}