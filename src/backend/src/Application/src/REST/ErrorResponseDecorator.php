<?php
namespace CASS\Application\REST;

use ZEA2\Platform\Bundles\REST\Response\Decorators\ResponseDecorator;
use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;

final class ErrorResponseDecorator implements ResponseDecorator
{
    public function decorate(ResponseBuilder $builder, array $response): array
    {
        $error = $builder->getError();
        
        if($error) {
            if($error instanceof \Exception) {
                $errorMessage = $error->getMessage();
                $response['error_stack'] = $error->getTrace();
            }else if($error instanceof \TypeError) {
                $errorMessage = $error->getMessage();
                $response['error_stack'] = $error->getTrace();
            }else if(is_string($error)) {
                $errorMessage = $error;
            }else if($error === null){
                $errorMessage = 'No error message available';
            }else{
                $errorMessage = (string) $error;
            }

            return $response + ['error' => $errorMessage];
        }else{
            return $response;
        }
    }
}