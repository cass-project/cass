<?php


namespace Domain\PostReport\Middleware;


use Application\REST\Response\GenericResponseBuilder;
use Application\Service\CommandService;
use Domain\PostReport\Middleware\Command\CreateCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Stratigility\MiddlewareInterface;

class PostReportMiddleware implements MiddlewareInterface
{
  /** @var  CommandService */
  private $commandService;
  public function __construct(CommandService $commandService)
  {
    $this->commandService = $commandService;
  }
  public function __invoke(Request $request, Response $response, callable $out = NULL)
  {
    $responseBuilder = new GenericResponseBuilder($response);
    $resolver = $this->commandService->createResolverBuilder()
      ->attachDirect('create', CreateCommand::class)
      ->resolve($request);

    try {
      return $resolver->run($request, $responseBuilder);
    }catch(Exception $e) {
      return $responseBuilder
        ->setError($e)
        ->build();
    }

  }

}