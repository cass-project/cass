<?php
namespace CASS\Domain\Bundles\IM\Query;

use CASS\Domain\Bundles\IM\Query\Options\OptionsManager;
use CASS\Domain\Bundles\IM\Query\Criteria\CriteriaManager;
use CASS\Domain\Bundles\IM\Query\Source\Source;

final class Query
{
    /** @var Source */
    private $source;
    
    /** @var CriteriaManager */
    private $criteria;
    
    /** @var OptionsManager */
    private $options;

    /**
     * Query constructor.
     * @param Source $source
     * @param CriteriaManager $criteria
     * @param OptionsManager $options
     */
    public function __construct(Source $source, CriteriaManager $criteria, OptionsManager $options)
    {
        $this->source = $source;
        $this->criteria = $criteria;
        $this->options = $options;
    }
    
    public function getSource(): Source
    {
        return $this->source;
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