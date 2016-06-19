<?php


namespace Domain\Feedback\Middleware;


use Application\REST\Response\GenericResponseBuilder;
use Application\Service\CommandService;
use Domain\Feedback\Middleware\Command\CreateCommand;
use Domain\Feedback\Middleware\Command\DeleteCommand;
use Domain\Feedback\Middleware\Command\GetAllCommand;
use Domain\Feedback\Middleware\Command\GetHasAnswerCommand;
use Domain\Feedback\Middleware\Command\GetWithoutAnswerCommand;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Symfony\Component\Config\Definition\Exception\Exception;
use Zend\Stratigility\MiddlewareInterface;

class FeedbackMiddleware implements MiddlewareInterface
{

  /** @var CommandService $commandService */
  private $commandService;

  public function __construct(CommandService $commandService)
  {
    $this->commandService = $commandService;
  }

  public function __invoke(Request $request, Response $response, callable $out = NULL)
  {
    $responseBuilder = new GenericResponseBuilder($response);

    $resolver = $this->commandService->createResolverBuilder()
                                     ->attachDirect("create", CreateCommand::class)
                                     ->attachDirect("cancel", DeleteCommand::class)
                                     ->attachDirect("has-answer", GetHasAnswerCommand::class)
                                     ->attachDirect("without-answer", GetWithoutAnswerCommand::class)
                                     ->attachDirect("all", GetAllCommand::class)
                                     ->resolve($request);

    try {
      return $resolver->run($request, $responseBuilder);
    }catch(\Exception $e) {
      return $responseBuilder
        ->setError($e)
        ->build();
    }
  }

}