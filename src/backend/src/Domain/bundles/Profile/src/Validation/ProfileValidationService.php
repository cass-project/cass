<?php
namespace Domain\Profile\Validation;
use CASS\Application\Exception\PermissionsDeniedException;
use Domain\Account\Entity\Account;
use Domain\Profile\Entity\Profile;

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