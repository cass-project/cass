<?php
namespace Domain\IM\Parameters;

use Domain\IM\Exception\Query\Options\OptionsFactory;
use Domain\IM\Exception\Query\Options\OptionsManager;
use Domain\IM\Parameters\Messages\Criteria\CriteriaFactory;
use Domain\IM\Parameters\Messages\Criteria\CriteriaManager;

final class MessagesParameters
{
    /** @var CriteriaManager */
    private $criteria;

    /** @var OptionsManager */
    private $options;

    public function __construct(array $json, CriteriaFactory $criteriaFactory, OptionsFactory $optionsFactory)
    {
        $arrOptions = [];
        $arrCriteria = [];

        foreach($json['criteria'] ?? [] as $code => $params) {
            $criteria = $criteriaFactory->createCriteriaFromStringCode($code);
            $criteria->unpack($params);

            $arrOptions[] = $criteria;
        }

        foreach($json['options'] ?? [] as $code => $params) {
            $option = $optionsFactory->createFromStringCode($code);
            $option->unpack($params);

            $arrCriteria[] = $option;
        }

        $this->criteria = new CriteriaManager($arrCriteria);
        $this->options = new OptionsManager($arrOptions);
    }

    public function getCriteria(): CriteriaManager
    {
        return $this->criteria;
    }

    public function getOptions(): OptionsManager
    {
        return $this->options;
    }
}