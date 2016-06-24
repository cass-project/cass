<?php
namespace Application\Version\Frontline;

use Application\Frontline\FrontlineScript;
use Application\Version\Service\VersionService;

final class VersionFrontlineScript implements FrontlineScript
{
    /** @var VersionService */
    private $version;

    public function __construct(VersionService $version)
    {
        $this->version = $version;
    }

    public function tags(): array
    {
        return [
            FrontlineScript::TAG_GLOBAL,
        ];
    }

    public function __invoke(): array
    {
        return [
            'version' => $this->version->getCurrentVersion(),
        ];
    }
}