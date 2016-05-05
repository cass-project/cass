<?php
namespace Community\Middleware\Request;

use Common\Tools\RequestParams\RequestParamsInterface;
use Common\Util\Definitions\Point;
use Community\Parameters\UploadImageParameters;
use Psr\Http\Message\ServerRequestInterface;

class UploadImageRequest implements RequestParamsInterface
{
    /** @var RequestParamsInterface */
    private $request;

    public function __construct(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    public function getParameters(): UploadImageParameters
    {
        $request = $this->request;

        $pointStart = new Point(
            (int) $request->getAttribute('x1'),
            (int) $request->getAttribute('y1')
        );

        $pointEnd = new Point(
            (int) $request->getAttribute('x2'),
            (int) $request->getAttribute('y2')
        );

        return new UploadImageParameters($_FILES['file']['tmp_name'], $pointStart, $pointEnd);
    }
}