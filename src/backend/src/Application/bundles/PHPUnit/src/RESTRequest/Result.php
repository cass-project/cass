<?php
namespace CASS\Application\PHPUnit\RESTRequest;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Stratigility\Http\Response;

class Result
{
    /**
     * HTTP-запрос, который был отправлен
     * @var ServerRequestInterface
     */
    private $httpRequest;

    /**
     * HTTP-ответ, полученный от бэкенда
     * @var Response
     */
    private $httpResponse;

    /**
     * JSON Body
     * @var array
     */
    private $content;

    public function __construct(ServerRequestInterface $httpRequest, Response $httpResponse, array $content)
    {
        $this->httpRequest = $httpRequest;
        $this->httpResponse = $httpResponse;
        $this->content = $content;
    }

    public function getHttpRequest(): ServerRequestInterface
    {
        return $this->httpRequest;
    }

    public function getHttpResponse(): Response
    {
        return $this->httpResponse;
    }

    public function getContent(): array
    {
        return $this->content;
    }
}