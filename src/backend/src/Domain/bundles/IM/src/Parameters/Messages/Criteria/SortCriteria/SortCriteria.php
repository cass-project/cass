<?php
namespace Domain\IM\Parameters\Messages\Criteria\SortCriteria;

use Domain\IM\Exception\Query\InvalidCriteriaParamsException;
use Domain\IM\Parameters\Messages\Criteria\Criteria;

final class SortCriteria implements Criteria
{
    const CRITERIA_CODE = 'sort';
    const SORT_ASC = 'asc';
    const SORT_DESC = 'desc';

    /** @var string */
    private $field;

    /** @var string */
    private $order;

    public static function getCode(): string
    {
        return self::CRITERIA_CODE;
    }

    public function unpack(array $params)
    {
        $this->field = $params['field'] ?? '';
        $this->order = strtolower($params['order'] ?? '');

        if(! strlen($this->field)) {
            throw new InvalidCriteriaParamsException(sprintf('No field available'));
        }

        if(! in_array($this->order, [
            self::SORT_ASC,
            self::SORT_DESC
        ])) {
            throw new InvalidCriteriaParamsException(sprintf('Order should be `%s` or `%s`, got `%s`', self::SORT_DESC, self::SORT_ASC, $this->order));
        }
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