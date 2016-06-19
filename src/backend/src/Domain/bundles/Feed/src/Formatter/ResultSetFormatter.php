<?php
namespace Domain\Feed\Formatter;

use Domain\Feed\Feed\ResultSet;
use Domain\Post\Entity\Post;
use Domain\Profile\Entity\Profile\Greetings;
use Domain\Profile\Repository\ProfileRepository;

class ResultSetFormatter
{
    /** @var ProfileRepository */
    private $profileRepository;

    public function __construct(ProfileRepository $profileRepository) {
        $this->profileRepository = $profileRepository;
    }

    public function toJSON(ResultSet $resultSet)
    {
        $cachedProfiles = $this->profileRepository->getProfileByIds($this->getProfileIdsToCache($resultSet));

        return [
            'total' => $resultSet->getTotal(),
            'posts' => array_map(function(Post $post) {
                return $post->toJSON();
            }, $resultSet->getPosts()),
            'cached_profiles' => array_map(function(Profile $profile) {
                return $profile->toJSON();
            }, $cachedProfiles)
        ];
    }

    private function getProfileIdsToCache(ResultSet $resultSet) {
        $profileIds = [];

        foreach($resultSet->getPosts() as $post) {
            $profileIds[$post->getAuthorProfile()->getId()] = true;
        }

        return array_keys($profileIds);
    }
}