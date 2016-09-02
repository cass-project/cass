<?php
namespace CASS\Domain\IM\Query\Criteria\CursorCriteria;

use CASS\Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use CASS\Domain\IM\Query\Criteria\Criteria;

final class CursorCriteria implements Criteria
{
    const CRITERIA_CODE = 'cursor';

    /** @var string */
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public static function createCriteriaFromParams(array $params): Criteria
    {
        if(! isset($params['id'])) {
            throw new InvalidCriteriaParamsException('No cursor.id available');
        }

        return new self((string) $params['id']);
    }

    public function getId(): string
    {
        return $this->id;
    }
}