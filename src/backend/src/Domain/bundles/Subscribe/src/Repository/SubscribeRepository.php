<?php
namespace CASS\Domain\Bundles\Subscribe\Repository;

use CASS\Domain\Bundles\Collection\Entity\Collection;
use CASS\Domain\Bundles\Community\Entity\Community;
use CASS\Domain\Bundles\Profile\Entity\Profile;
use CASS\Domain\Bundles\Subscribe\Entity\Subscribe;
use CASS\Domain\Bundles\Subscribe\Exception\ConflictSubscribe;
use CASS\Domain\Bundles\Subscribe\Exception\SubscribeException;
use CASS\Domain\Bundles\Subscribe\Exception\UnknownSubscribeException;
use CASS\Domain\Bundles\Theme\Entity\Theme;
use Doctrine\ORM\EntityRepository;

class SubscribeRepository extends EntityRepository
{
    public function subscribeTheme(Profile $profile, Theme $theme, $options = null): Subscribe
    {
        $subscribe = new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($theme->getId())
            ->setSubscribeType(Subscribe::TYPE_THEME);

        if($this->getSubscribeByEntity($subscribe)) {
            throw new ConflictSubscribe(sprintf("subscribe already exists "));
        }

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();

        return $subscribe;
    }

    public function unSubscribeTheme(Profile $profile, Theme $theme)
    {

        $criteria = ['profile_id' => $profile->getId(), 'theme_id' => $theme->getId(), 'type' => Subscribe::TYPE_THEME];
        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();
    }

    public function getSubscribe($criteria)
    {
        $subscribe = null;
        if(is_array($criteria)) {
            $subscribe = $this->getSubscribeByCriteria($criteria);
        }elseif($criteria instanceof Subscribe){
            $subscribe = $this->getSubscribeByEntity($criteria);
        }

        return $subscribe;
    }

    public function getSubscribeByCriteria(array $criteria)
    {
        if(! isset($criteria['profileId'])) {
            throw new SubscribeException("required option: profile_id missing");
        }
        if(! isset($criteria['subscribeId'])) {
            throw new SubscribeException("required option: subscribe_id missing");
        }
        if(! isset($criteria['subscribeType'])) {
            throw new SubscribeException("required option: type missing");
        }

        return $this->getEntityManager()->getRepository(Subscribe::class)->findOneBy($criteria);
    }

    private function getSubscribeByEntity(Subscribe $subscribe)
    {
        return $this->getSubscribeByCriteria([
            'profileId' => $subscribe->getProfileId(),
            'subscribeId' => $subscribe->getSubscribeId(),
            'subscribeType' => $subscribe->getSubscribeType(),
        ]);
    }

    public function subscribeProfile(Profile $profile1, Profile $profile2, $options = null): Subscribe
    {
        $subscribe = new Subscribe();
        $subscribe->setProfileId($profile1->getId())
            ->setOptions($options)
            ->setSubscribeId($profile2->getId())
            ->setSubscribeType(Subscribe::TYPE_PROFILE);

        if($this->getSubscribeByEntity($subscribe)) {
            throw new ConflictSubscribe(sprintf("subscribe already exists "));
        }

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();

        return $subscribe;
    }

    public function unSubscribeProfile(Profile $profile, Profile $subscribe)
    {
        $criteria = ['profile_id' => $profile->getId(), 'subscribe_id' => $subscribe->getId(), 'type' => Subscribe::TYPE_PROFILE];
        $subscribe = $this->getSubscribe($criteria);

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();
    }

    public function subscribeCollection(Profile $profile, Collection $collection, $options = null): Subscribe
    {
        $subscribe = new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($collection->getId())
            ->setSubscribeType(Subscribe::TYPE_COLLECTION);

        if($this->getSubscribeByEntity($subscribe)) {
            throw new ConflictSubscribe(sprintf("subscribe already exists "));
        }

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();

        return $subscribe;
    }

    public function subscribeCommunity(Profile $profile, Community $community, $options = null): Subscribe
    {
        $subscribe = new Subscribe();
        $subscribe->setProfileId($profile->getId())
            ->setOptions($options)
            ->setSubscribeId($community->getId())
            ->setSubscribeType(Subscribe::TYPE_COMMUNITY);

        if($this->getSubscribeByEntity($subscribe)) {
            throw new ConflictSubscribe(sprintf("subscribe already exists "));
        }

        $em = $this->getEntityManager();
        $em->persist($subscribe);
        $em->flush();

        return $subscribe;
    }

    public function unSubscribeByCriteria(array $criteria)
    {

        $subscribe = $this->getSubscribe($criteria);

        if($subscribe === null) {
            throw new UnknownSubscribeException(
                sprintf("Subscribe not found - (profileId: %s, subscribeId: %s, subscribeType): %s",
                    $criteria['profileId'],
                    $criteria['subscribeId'],
                    $criteria['subscribeType']
                )
            );
        }

        $em = $this->getEntityManager();
        $em->remove($subscribe);
        $em->flush();

        return $subscribe;
    }
}