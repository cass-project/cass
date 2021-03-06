<?php
namespace CASS\Domain\Bundles\Feed\Search\Stream\Streams;

use CASS\Domain\Bundles\Feed\Search\Stream\Stream;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\QueryStringCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SeekCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\SortCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\Criteria\ThemeIdCriteria;
use CASS\Domain\Bundles\Feed\Search\Criteria\CriteriaManager;
use CASS\Domain\Bundles\Profile\Exception\ProfileNotFoundException;
use CASS\Domain\Bundles\Profile\Formatter\ProfileFormatter;
use CASS\Domain\Bundles\Profile\Service\ProfileService;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection;
use MongoDB\Model\BSONDocument;

final class ProfileStream extends Stream
{
    /** @var ProfileService */
    private $profileService;

    /** @var ProfileFormatter */
    private $profileFeedFormatter;

    public function __construct(ProfileService $profileService, ProfileFormatter $profileFeedFormatter)
    {
        $this->profileService = $profileService;
        $this->profileFeedFormatter = $profileFeedFormatter;
    }

    public function fetch(CriteriaManager $criteriaManager, Collection $collection): array
    {
        $order = 1;
        $filter = [];
        $options = [
            'limit' => self::DEFAULT_LIMIT,
        ];

        $criteriaManager->doWith(SortCriteria::class, function(SortCriteria $criteria) use (&$options, &$order) {
            $order = strtolower($criteria->getOrder()) === 'asc' ? 1 : -1;

            $options['sort'] = [];
            $options['sort'][$criteria->getField()] = $order;
        });

        $criteriaManager->doWith(SeekCriteria::class, function(SeekCriteria $criteria) use (&$options, &$filter, $order) {
            $options['limit'] = $criteria->getLimit();
            $options['skip'] = 0;

            if($criteria->getLastId()) {
                $lastId = new ObjectID($criteria->getLastId());

                if($order === 1) {
                    $filter['_id'] = [
                        '$gt' => $lastId
                    ];
                }else{
                    $filter['_id'] = [
                        '$lt' => $lastId
                    ];
                }
            }
        });

        $criteriaManager->doWith(ThemeIdCriteria::class, function(ThemeIdCriteria $criteria) use (&$filter) {
            $filter[sprintf('theme_ids.%s', (string) $criteria->getThemeId())] = [
                '$exists' => true
            ];
        });

        $criteriaManager->doWith(QueryStringCriteria::class, function(QueryStringCriteria $criteria) use (&$filter) {
            if($criteria->isAvailable()) {
                $filter['$text'] = [
                    '$search' => $criteria->getQuery()
                ];
            }
        });

        $cursor = $collection->find($filter, $options)->toArray();

        if(count($cursor)) {
            $this->profileService->loadProfilesByIds(array_map(function(BSONDocument $document) {
                return (int) $document['id'];
            }, $cursor));

            return $this->cleanResults(array_map(function(BSONDocument $document) {
                try {
                    $profile = $this->profileService->getProfileById((int) $document['id']);

                    return array_merge([
                        '_id' => (string) $document['_id']
                    ], $this->profileFeedFormatter->formatOne($profile));
                }catch(ProfileNotFoundException $e) {
                    return null;
                }
            }, $cursor));
        }else{
            return [];
        }
    }
}