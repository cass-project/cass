<?php
namespace ProfileIM\Middleware;

use Auth\Service\CurrentAccountService;
use ProfileIM\Service\ProfileIMService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

class ProfileIMMiddleware implements MiddlewareInterface
{
    /** @var CurrentAccountService */
    private $currentAccountService;

    /** @var ProfileIMService */
    private $profileIMService;

    public function __construct(CurrentAccountService $currentAccountService, ProfileIMService $profileIMService)
    {
        $this->currentAccountService = $currentAccountService;
        $this->profileIMService = $profileIMService;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        return [];
    }
}