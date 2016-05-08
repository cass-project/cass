<?php
namespace Application\Common\Bootstrap;

use Application\Common\Exception\BadCommandCallException;
use Application\Common\Exception\CommandNotFoundException;
use Application\Common\Exception\PermissionsDeniedException;
use Application\Common\REST\GenericRESTResponseBuilder;
use Application\Common\Tools\RequestParams\InvalidJSONSchema;
use Application\Common\Exception\DataEntityNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Expressive\Container\Exception\NotFoundException;

class ErrorHandler
{
    public function __invoke(Request $request, Response $response, $error)
    {
        $responseBuilder = new GenericRESTResponseBuilder($response);
        $responseBuilder->setError($error);
        $responseBuilder->setStatusBadRequest();

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
            }catch(BadCommandCallException $e) {
                $responseBuilder->setStatusBadRequest();
            }catch(NotFoundException $e){
                $responseBuilder->setStatusNotFound();
            }catch(PermissionsDeniedException $e){
                $responseBuilder->setStatusNotAllowed();
            }
        }

        return $responseBuilder->setJson(['errorType' => $errorType])->build();
    }
}