<?php
namespace Domain\Request\Params;

use Psr\Http\Message\ServerRequestInterface;

abstract class RequestParams implements RequestParamsInterface
{
    /** @var ServerRequestInterface */
    private $request;

    /** @var mixed */
    private $parameters;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    protected function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    abstract protected function generateParams(ServerRequestInterface $request);

    public function getParameters()
    {
        if($this->parameters === null) {
            $this->parameters = $this->generateParams($this->request);
        }

        return $this->parameters;
    }
}