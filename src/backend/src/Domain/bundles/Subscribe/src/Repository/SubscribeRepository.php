<?php
namespace CASS\Domain\Bundles\Subscribe\Repository;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use Doctrine\ORM\EntityRepository;

class SubscribeRepository extends EntityRepository
{
    public function subscribeTheme(Profile $profile, Theme $theme, $options = null): Subscribe
    {
        $subscribe =  new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($theme->getId())
            ->setSubscribeType(Subscribe::TYPE_THEME);

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();
        return $subscribe;
    }

    public function unSubscribeTheme(Profile $profile, Theme $theme){

        $criteria = ['profile_id' => $profile->getId(), 'theme_id' => $theme->getId(), 'type' => Subscribe::TYPE_THEME ];
        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();
    }


    public function getSubscribe(array $criteria): Subscribe
    {
        if (!isset($criteria['profileId'])) throw new \Exception("required option: profile_id missing");
        if (!isset($criteria['subscribeId'])) throw new \Exception("required option: subscribe_id missing");
        if (!isset($criteria['subscribeType'])) throw new \Exception("required option: type missing");
        $subscribe = $this->getEntityManager()->getRepository(Subscribe::class)->findOneBy($criteria);

        if ($subscribe === null)
            throw new UnknownSubscribeException(
                sprintf("Subscribe not found - (profileId: %s, subscribeId: %s, subscribeType): %s",
                    $criteria['profileId'],
                    $criteria['subscribeId'],
                    $criteria['subscribeType']
                )
            );
        return $subscribe;
    }

    public function subscribeProfile(Profile $profile1, Profile $profile2, $options = null): Subscribe
    {
        $subscribe =  new Subscribe();
        $subscribe->setProfileId($profile1->getId())
            ->setOptions($options)
            ->setSubscribeId($profile2->getId())
            ->setSubscribeType(Subscribe::TYPE_PROFILE);

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();
        return $subscribe;
    }

    public function unSubscribeProfile(Profile $profile, Profile $subscribe)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $subscribe->getId(), 'type' => Subscribe::TYPE_PROFILE ];
        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();
    }

    public function subscribeCollection(Profile $profile, Collection $collection, $options = null): Subscribe
    {
        $subscribe =  new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($collection->getId())
            ->setSubscribeType(Subscribe::TYPE_COLLECTION);

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();
        return $subscribe;
    }

    public function subscribeCommunity(Profile $profile, Community $community, $options = null ): Subscribe
    {
        $subscribe =  new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($community->getId())
            ->setSubscribeType(Subscribe::TYPE_COMMUNITY);

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();
        return $subscribe;
    }

    public function unSubscribeByCriteria(array $criteria)
    {

        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();

        return $subscribe;
    }
}