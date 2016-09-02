<?php
namespace CASS\Domain\IM\Query;

use CASS\Domain\IM\Query\Options\OptionsFactory;
use CASS\Domain\IM\Query\Criteria\CriteriaFactory;
use CASS\Domain\IM\Query\Criteria\CriteriaManager;
use CASS\Domain\IM\Query\Options\OptionsManager;
use CASS\Domain\IM\Query\Source\Source;

final class QueryFactory
{
    /** @var CriteriaFactory */
    private $criteriaFactory;

    /** @var OptionsFactory */
    private $optionFactory;

    public function __construct(
        CriteriaFactory $criteriaFactory,
        OptionsFactory $optionFactory
    )
    {
        $this->criteriaFactory = $criteriaFactory;
        $this->optionFactory = $optionFactory;
    }

    public function createQueryFromJSON(Source $source, array $json): Query
    {
        $criteria = [];
        $options = [];

        foreach($json['criteria'] as $code => $params) {
            $criteria[] = $this->criteriaFactory->createCriteriaFromStringCode($code, $params);
        }

        foreach($json['options'] as $code => $params) {
            $options[] = $this->optionFactory->createFromStringCode($code, $params);
        }

        return new Query($source, new CriteriaManager($criteria), new OptionsManager($options));
    }
}