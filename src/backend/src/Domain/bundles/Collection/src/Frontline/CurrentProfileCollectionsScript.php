<?php
namespace Domain\Collection\Frontline;

use Application\Frontline\FrontlineScript;
use Domain\Auth\Service\CurrentAccountService;
use Domain\Collection\Formatter\CollectionTreeFormatter;
use Domain\Collection\Service\CollectionService;

class CurrentProfileCollectionsScript implements FrontlineScript
{
    /** @var CollectionService */
    private $collectionService;

    /** @var CurrentAccountService */
    private $currentAccountService;

    public function __construct(CollectionService $collectionService, CurrentAccountService $currentAccountService) {
        $this->collectionService = $collectionService;
        $this->currentAccountService = $currentAccountService;
    }

    public function __invoke(): array {
        $currentAccountService = $this->currentAccountService;
        $collectionService = $this->collectionService;

        if ($currentAccountService->isAvailable()) {
            $profileId = $currentAccountService->getCurrentProfile()->getId();

            return [
                'collections' => (new CollectionTreeFormatter())->format($collectionService->getRootCollections($profileId))
            ];
        } else {
            return [];
        }
    }

}