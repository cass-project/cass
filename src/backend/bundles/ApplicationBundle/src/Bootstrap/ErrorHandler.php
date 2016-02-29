<?php
namespace Application\Bootstrap;

use Application\Exception\CommandNotFoundException;
use Application\REST\GenericRESTResponseBuilder;
use Application\Tools\RequestParams\InvalidJSONSchema;
use Data\Exception\DataEntityNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ErrorHandler
{
    public function __invoke(Request $request, Response $response, $error)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $responseBuilder->setError($error);

        $errorType = 'unknown';

        if($error instanceof \Exception) {
            $errorType = get_class($error);

            try {
                throw $error;
            }catch(DataEntityNotFoundException $e){
                $responseBuilder->setStatusNotFound();
            }catch(InvalidJSONSchema $e){
                $responseBuilder->setStatusBadRequest();
            }catch(CommandNotFoundException $e) {
                $responseBuilder->setStatusNotFound();
            }
        }

        return $responseBuilder->setJson(['errorType' => $errorType])->build();
    }
}