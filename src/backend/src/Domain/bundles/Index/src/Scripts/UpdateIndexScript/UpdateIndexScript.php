<?php
namespace CASS\Domain\Bundles\Index\Scripts\UpdateIndexScript;

use CASS\Domain\Bundles\Collection\Service\CollectionService;
use CASS\Domain\Bundles\Community\Service\CommunityService;
use CASS\Domain\Bundles\Profile\Service\ProfileService;

final class UpdateIndexScript
{
    /** @var ProfileService */
    private $profileService;

    /** @var CollectionService */
    private $collectionService;

    /** @var CommunityService */
    private $communityService;

    private function updateProfileEntities() {}
    private function updateExpertsEntities() {}
    private function updateCommunityEntities() {}
    private function updateCollectionEntities() {}
}