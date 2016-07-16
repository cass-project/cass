<?php
namespace Domain\IM\Parameters\Messages\Criteria\CursorCriteria;

use Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use Domain\IM\Parameters\Messages\Criteria\Criteria;

final class CursorCriteria implements Criteria
{
    const CRITERIA_CODE = 'cursor';

    /** @var string */
    private $id;

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public function unpack(array $params)
    {
        if(! isset($params['id'])) {
            throw new InvalidCriteriaParamsException('No cursor.id available');
        }

        $this->id = (string) $params['id'];
    }

    public function getId(): string
    {
        return $this->id;
    }
}