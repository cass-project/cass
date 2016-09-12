<?php
namespace CASS\Domain\Bundles\Subscribe\Repository;

use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use Doctrine\ORM\EntityRepository;

class SubscribeRepository extends EntityRepository
{
    public function subscribeTheme(Profile $profile, Theme $theme): Subscribe
    {
        
    }

    public function unSubscribeTheme(Profile $profile, Theme $theme){

    }
}