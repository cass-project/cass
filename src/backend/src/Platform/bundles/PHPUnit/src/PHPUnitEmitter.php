<?php
namespace ZEA2\Platform\Bundles\PHPUnit;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\Response\SapiEmitterTrait;

class PHPUnitEmitter extends SapiEmitter
{
    use SapiEmitterTrait;

    public function emit(ResponseInterface $response, $maxBufferLevel = null) {
        $response = $this->injectContentLength($response);

        $this->flush($maxBufferLevel);
        $this->emitBody($response);
    }

    private function emitBody(ResponseInterface $response)
    {
        echo $response->getBody();
    }
}