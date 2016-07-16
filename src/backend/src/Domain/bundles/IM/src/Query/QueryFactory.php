<?php
namespace Domain\IM\Query;

use Domain\IM\Exception\Query\Options\OptionsFactory;
use Domain\IM\Query\Criteria\CriteriaFactory;
use Domain\IM\Query\Criteria\CriteriaManager;
use Domain\IM\Query\Options\OptionsManager;
use Domain\IM\Query\Source\SourceFactory;

final class QueryFactory
{
    /** @var SourceFactory */
    private $sourceFactory;

    /** @var CriteriaFactory */
    private $criteriaFactory;

    /** @var OptionsFactory */
    private $optionFactory;

    public function __construct(
        SourceFactory $sourceFactory,
        CriteriaFactory $criteriaFactory,
        OptionsFactory $optionFactory
    )
    {
        $this->sourceFactory = $sourceFactory;
        $this->criteriaFactory = $criteriaFactory;
        $this->optionFactory = $optionFactory;
    }

    public function createQueryFromJSON(array $json): Query
    {
        $criteria = [];
        $options = [];
        $source = $this->sourceFactory->createSource($json['source']['code'], $json['source']['params']);

        foreach($json['criteria'] as $code => $params) {
            $criteria[] = $this->criteriaFactory->createCriteriaFromStringCode($code, $params);
        }

        foreach($json['options'] as $code => $params) {
            $options[] = $this->optionFactory->createFromStringCode($code, $params);
        }

        return new Query($source, new CriteriaManager($criteria), new OptionsManager($options));
    }
}