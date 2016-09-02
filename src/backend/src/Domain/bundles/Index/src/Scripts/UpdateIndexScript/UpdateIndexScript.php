<?php
namespace CASS\Domain\Index\Scripts\UpdateIndexScript;

use CASS\Domain\Collection\Service\CollectionService;
use CASS\Domain\Community\Service\CommunityService;
use CASS\Domain\Profile\Service\ProfileService;

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