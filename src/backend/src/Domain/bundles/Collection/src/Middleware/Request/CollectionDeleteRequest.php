<?php
namespace Domain\Collection\Middleware\Request;

use Domain\Collection\Service\Parameters\CollectionService\CollectionDeleteParameters;
use Application\REST\Request\Params\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class CollectionDeleteRequest extends RequestParams
{
    public function generateParams(ServerRequestInterface $request)
    {
        $collectionId = (int) $request->getAttribute('collectionId');

        return new CollectionDeleteParameters($collectionId);
    }
}