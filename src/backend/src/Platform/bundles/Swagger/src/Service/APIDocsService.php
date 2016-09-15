<?php
namespace ZEA2\Platform\Bundles\Swagger\Service;

use CASS\Application\Service\BundleService;
use ZEA2\Platform\Bundles\Swagger\APIDocs\APIDocsBuilder;
use ZEA2\Platform\Bundles\Swagger\APIDocs\APIDocsBuilderRequest;

class APIDocsService
{
    /**
     * @var \CASS\Application\Service\BundleService
     */
    private $bundlesService;

    /** @var string[] */
    private $excludedBundles = [];

    public function __construct(BundleService $bundlesService, array $excludedBundles = [])
    {
        $this->bundlesService = $bundlesService;
        $this->excludedBundles = $excludedBundles;
    }

    public function buildAPIDocs() {
        $apiDocsBuilderRequest = $this->createAPIDocsBuilderRequest();
        $apiDocsBuilder = new APIDocsBuilder($apiDocsBuilderRequest);

        return $apiDocsBuilder->build();
    }

    private function createAPIDocsBuilderRequest()
    {
        $apiDocsBuilderRequest = new APIDocsBuilderRequest();

        foreach ($this->bundlesService->getBundles() as $bundle) {
            if(in_array(get_class($bundle), $this->excludedBundles)) {
                continue;
            }

            if ($bundle->hasAPIDocsDir()) {
                $apiDocsBuilderRequest->addDirectory($bundle->getAPIDocsDir());
            }
        }

        return $apiDocsBuilderRequest;
    }
}