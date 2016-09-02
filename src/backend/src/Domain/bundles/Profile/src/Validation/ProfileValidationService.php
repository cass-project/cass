<?php
namespace CASS\Domain\Profile\Validation;
use CASS\Application\Exception\PermissionsDeniedException;
use CASS\Domain\Account\Entity\Account;
use CASS\Domain\Profile\Entity\Profile;

final class ProfileValidationService
{
    public function validateIsProfileOwnedByAccount(Account $account, Profile $profile): self
    {
        if (!$account->getProfiles()->contains($profile)) {
            throw new PermissionsDeniedException("You're not an owner of this profile");
        }
        return $this;
    }
}