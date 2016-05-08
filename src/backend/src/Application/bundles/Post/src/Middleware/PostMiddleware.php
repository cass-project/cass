<?php
namespace Application\Post\Middleware;

use Application\Auth\Service\CurrentAccountService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Common\Service\TransactionService;
use Application\Post\Exception\PostNotFoundException;
use Application\Post\Middleware\Command\Command;
use Application\Post\Service\PostService;
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
        $responseBuilder = new GenericRESTResponseBuilder($response);
        
        try {
            $command = Command::factory($request, $this->currentAccountService, $this->postService);
            $result = $command->run($request);

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);
        }catch(PostNotFoundException $e) {
            $responseBuilder
                ->setStatusNotFound()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}