<?php
namespace Domain\Avatar\Middleware\Request;

use Application\Exception\FileNotUploadedException;
use Application\REST\Request\Params\RequestParamsInterface;
use Application\Util\Definitions\Point;
use Domain\Avatar\Parameters\UploadImageParameters;
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

        if(! isset($request->getUploadedFiles()['file'])) {
            throw new FileNotUploadedException('File not is not uploaded');
        }

        /** @var UploadedFile $file */
        $file = $request->getUploadedFiles()['file'];

        return new UploadImageParameters($file->getStream()->getMetadata('uri'), $pointStart, $pointEnd);
    }
}