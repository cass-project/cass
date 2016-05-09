<?php
namespace Domain\Community\Middleware\Request;

use Application\REST\Request\Params\RequestParamsInterface;
use Application\Util\Definitions\Point;
use Domain\Community\Parameters\UploadImageParameters;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\UploadedFile;

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

        /** @var UploadedFile $file */
        $file = $request->getUploadedFiles()['file'];
        $file->getStream()->getMetadata('uri');

        return new UploadImageParameters($file->getStream()->getMetadata('uri'), $pointStart, $pointEnd);
    }
}