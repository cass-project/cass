<?php
namespace Domain\Profile\Repository;

use Doctrine\ORM\EntityRepository;

class ProfileInterestingInEQRepository extends EntityRepository
{
    public function getProfilesByThemeId(int $themeId): array
    {
        /** @var int[] $result */
        $result = $this->findBy([
            'theme_id' => $themeId
        ]);

        return $result;
    }
}