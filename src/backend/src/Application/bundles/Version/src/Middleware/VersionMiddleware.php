<?php
namespace CASS\Application\Bundles\Version\Middleware;

use ZEA2\Platform\Bundles\REST\Response\ResponseBuilder;
use CASS\Application\Bundles\Version\Service\VersionService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

final class VersionMiddleware implements MiddlewareInterface
{
    /** @var VersionService */
    private $version;

    public function __construct(VersionService $version)
    {
        $this->version = $version;
    }

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        return (new ResponseBuilder($response))->setStatusSuccess()->setJson([
            'version' => $this->version->getCurrentVersion(),
            'blacklist' => $this->version->getBlacklistedFrontendSPAVersions(),
        ])->build();
    }
}