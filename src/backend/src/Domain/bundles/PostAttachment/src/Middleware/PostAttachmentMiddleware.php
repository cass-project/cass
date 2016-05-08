<?php
namespace Domain\PostAttachment\Middleware;

use Domain\Auth\Service\CurrentAccountService;
use Application\Common\REST\GenericRESTResponseBuilder;
use Domain\PostAttachment\Exception\PostAttachmentFactoryException;
use Domain\PostAttachment\Middleware\Command\Command;
use Domain\PostAttachment\Service\PostAttachmentService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class PostAttachmentMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    protected $currentAccountService;

    /** @var PostAttachmentService */
    protected $postAttachmentService;

    public function __construct(CurrentAccountService $currentAccountService, PostAttachmentService $postAttachmentService) {
        $this->currentAccountService = $currentAccountService;
        $this->postAttachmentService = $postAttachmentService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null) {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $command = Command::factory($request, $this->currentAccountService, $this->postAttachmentService);

        try {
            $result = $command->run($request);

            if($result === true) {
                $result = [];
            }

            $responseBuilder
                ->setStatusSuccess()
                ->setJson($result);
        }catch(PostAttachmentFactoryException $e) {
            $responseBuilder
                ->setStatusBadRequest()
                ->setError($e);
        }

        return $responseBuilder->build();
    }
}