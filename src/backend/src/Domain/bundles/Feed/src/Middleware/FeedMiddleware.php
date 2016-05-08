<?php
namespace Domain\Feed\Middleware;

use Application\Common\REST\GenericRESTResponseBuilder;
use Domain\Feed\Feed\ResultSet;
use Domain\Feed\Feed\Source;
use Domain\Feed\Service\FeedSourcesService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Container\Exception\NotFoundException;
use Zend\Stratigility\MiddlewareInterface;

class FeedMiddleware implements MiddlewareInterface
{
    const SOURCE_COLLECTION = 'collection';
    
    /** @var FeedSourcesService */
    private $feedSourcesService;
    
    public function __construct(FeedSourcesService $feedSourcesService) {
        $this->feedSourcesService = $feedSourcesService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) {
        $responseBuilder = new GenericRESTResponseBuilder($response);

        $feedRequest = new FeedRequest($request);

        $criteria = $feedRequest->getCriteriaRequest();
        $source = $this->sourceFactory($request);
        $query = $source->createQuery($criteria);
        $result = $query->execute();

        if($result instanceof ResultSet) {
            $formatter = $this->feedSourcesService->getResultSetFormatter();
            $responseBuilder->setJson($formatter->toJSON($result));
        }else if(is_array($result)) {
            $responseBuilder->setJson($result);
        }else{
            throw new \Exception('Unknown result format');
        }

        $responseBuilder->setStatusSuccess();

        return $responseBuilder->build();
    }
    
    private function sourceFactory(ServerRequestInterface $request): Source {
        $source = $request->getAttribute('source');
        
        switch($source) {
            default:
                throw new NotFoundException(sprintf('Unknown source `%s`', $source));
            case self::SOURCE_COLLECTION:
                return $this->feedSourcesService->getCollectionSourcePrototype(
                    (int) $request->getAttribute('collectionId')
                );
        }
    }
}