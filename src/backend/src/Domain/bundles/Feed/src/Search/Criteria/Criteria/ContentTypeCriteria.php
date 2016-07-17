<?php
namespace Domain\Feed\Search\Criteria\Criteria;

use Domain\Feed\Search\Criteria\Criteria;

final class ContentTypeCriteria implements Criteria
{
    const CRITERIA_CODE = 'content_type';

    const CONTENT_TYPE_TEXT = 'text';
    const CONTENT_TYPE_VIDEO = 'video';
    const CONTENT_TYPE_AUDIO = 'audio';
    const CONTENT_TYPE_IMAGE = 'image';
    const CONTENT_TYPE_LINK = 'link';

    public function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public function unpack(array $criteria)
    {
        return $criteria['type'];
    }
}