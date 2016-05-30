<?php
namespace Domain\Post\Middleware;

use Domain\Auth\Service\CurrentAccountService;
use Application\REST\Response\GenericResponseBuilder;
use Domain\Collection\Exception\CollectionNotFoundException;
use Domain\Post\Exception\PostNotFoundException;
use Domain\Post\Middleware\Command\Command;
use Domain\Post\Service\PostService;
use Domain\Profile\Exception\ProfileNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var PostService */
    private $postService;

    public function __construct(CurrentAccountService $currentAccountService, PostService $postService) {
        $this->currentAccountService = $currentAccountService;
        $this->postService = $postService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) 
    {
        $responseBuilder = new GenericResponseBuilder($response);
        
        try {
            $command = Command::factory($request, $this->currentAccountService, $this->postService);
            $result = $command->run($request);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);
        }
        catch(CollectionNotFoundException $e){
            $responseBuilder
              ->setStatusNotFound()
              ->setError($e);
        }
        catch(ProfileNotFoundException $e){
            $responseBuilder
              ->setStatusNotFound()
              ->setError($e);
        }
        catch(PostNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}