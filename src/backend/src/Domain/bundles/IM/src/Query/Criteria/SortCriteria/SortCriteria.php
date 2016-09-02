<?php
namespace CASS\Domain\IM\Query\Criteria\SortCriteria;

use CASS\Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use CASS\Domain\IM\Query\Criteria\Criteria;

final class SortCriteria implements Criteria
{
    const CRITERIA_CODE = 'sort';
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    /** @var string */
    private $field;

    /** @var string */
    private $order;

    public function __construct(string $field, string $order)
    {
        if(! strlen($field)) {
            throw new InvalidCriteriaParamsException(sprintf('No field available'));
        }

        if(! in_array($order, [
            self::SORT_ASC,
            self::SORT_DESC
        ])) {
            throw new InvalidCriteriaParamsException(sprintf('Order should be `%s` or `%s`, got `%s`', self::SORT_DESC, self::SORT_ASC, $this->order));
        }

        $this->field = $field;
        $this->order = $order;
    }

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public static function createCriteriaFromParams(array $params): Criteria
    {
        $field = $params['field'] ?? '';
        $order = strtolower($params['order'] ?? '');

        return new self($field, $order);
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getOrder(): string
    {
        return $this->order;
    }
}