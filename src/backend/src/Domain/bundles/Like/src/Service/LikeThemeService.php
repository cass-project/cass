<?php

namespace CASS\Domain\Bundles\Like\Service;

use CASS\Domain\Bundles\Like\Entity\Attitude;
use CASS\Domain\Bundles\Like\Exception\AttitudeAlreadyExistsException;
use CASS\Domain\Bundles\Like\Repository\LikeRepository\LikeRepository;
use CASS\Domain\Bundles\Theme\Repository\ThemeRepository;
use ZEA2\Platform\Markers\LikeEntity\LikeableEntity;

class LikeThemeService extends LikeService
{
    protected $themeRepository;
    public function __construct(LikeRepository $likeRepository, ThemeRepository $themeRepository)
    {
        parent::__construct($likeRepository);
        $this->themeRepository = $themeRepository;
    }

    public function addLike(LikeableEntity $entity, Attitude $attitude): Attitude
    {
        $attitude->setAttitudeType(Attitude::ATTITUDE_TYPE_LIKE);

        if($this->likeRepository->isAttitudeExists($attitude)) {
            $existAttitude = $this->likeRepository->getAttitude($attitude);
            switch($existAttitude->getAttitudeType()) {
                case Attitude::ATTITUDE_TYPE_LIKE:
                    throw new AttitudeAlreadyExistsException(sprintf("Сurrent LIKE attitude already exists"));
                    break;
                case Attitude::ATTITUDE_TYPE_DISLIKE:
                    $this->likeRepository->removeAttitude($existAttitude);
                    $entity->decreaseDislikes();
                    break;
            }
        }

        $attitude = $this->likeRepository->saveAttitude($attitude);
        $this->themeRepository->saveTheme($entity->increaseLikes());
        return $attitude;
    }

    public function addDislike(LikeableEntity $entity, Attitude $attitude): Attitude
    {
        // TODO: Implement addDislike() method.
    }

    public function removeLike(LikeableEntity $entity, Attitude $attitude)
    {
        // TODO: Implement removeLike() method.
    }

    public function removeDislike(LikeableEntity $entity, Attitude $attitude)
    {
        // TODO: Implement removeDislike() method.
    }

}