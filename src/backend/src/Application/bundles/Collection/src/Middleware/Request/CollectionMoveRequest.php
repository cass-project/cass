<?php
namespace Application\Collection\Middleware\Request;

use Application\Collection\Service\Parameters\CollectionService\CollectionMoveParameters;
use Application\Common\Tools\RequestParams\RequestParams;
use Psr\Http\Message\ServerRequestInterface;

class CollectionMoveRequest extends RequestParams
{
    protected function generateParams(ServerRequestInterface $request)
    {
        $collectionId = (int) $request->getAttribute('collectionId');
        $position = (int) $request->getAttribute('position');

        switch($parentId = $request->getAttribute('collectionParentId')) {
            case 0:
            case null:
            case 'null':
            case 'root':
            case 'none':
                $parentId = 0;
                break;

            default:
                $parentId = (int) $parentId;
                break;
        }
        return new CollectionMoveParameters($collectionId, $parentId, $position);
    }
}