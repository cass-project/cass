<?php
namespace CASS\Chat\Bundles\Contact\Service;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Util\Seek;

interface IContactService
{
    public function getContacts(Profile $profile, Seek $seek): array ;
}