<?php
namespace Domain\Index\Scripts\UpdateIndexScript;

use Domain\Collection\Service\CollectionService;
use Domain\Community\Service\CommunityService;
use Domain\Profile\Service\ProfileService;

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