<?php
namespace CASS\Domain\Bundles\Avatar\Parameters;

use CASS\Util\Definitions\Point;

class UploadImageParameters
{
    /** @var string */
    private $tmpFile;

    /** @var Point */
    private $pointStart;

    /** @var Point */
    private $pointEnd;

    public function __construct(string $tmpFile, Point $pointStart, Point $pointEnd)
    {
        $this->tmpFile = $tmpFile;
        $this->pointStart = $pointStart;
        $this->pointEnd = $pointEnd;
    }

    public function getTmpFile(): string
    {
        return $this->tmpFile;
    }

    public function getPointStart(): Point
    {
        return $this->pointStart;
    }

    public function getPointEnd(): Point
    {
        return $this->pointEnd;
    }
}