<?php
namespace Swagger\Service;

use Common\Bootstrap\Bundle\BundleService;
use Swagger\APIDocs\APIDocsBuilder;
use Swagger\APIDocs\APIDocsBuilderRequest;

class APIDocsService
{
    /**
     * @var BundleService
     */
    private $bundlesService;

    public function __construct(BundleService $bundlesService)
    {
        $this->bundlesService = $bundlesService;
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
            if ($bundle->hasAPIDocsDir()) {
                $apiDocsBuilderRequest->addDirectory($bundle->getAPIDocsDir());
            }
        }

        return $apiDocsBuilderRequest;
    }
}