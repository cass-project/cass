<?php
namespace CASS\Domain\Bundles\Community\Entity\Community;

class CommunityFeatures
{
    /** @var string[] */
    private $features = [];

    public function __construct(array &$features)
    {
        $this->features = $features;
    }

    public function hasFeature(string $code)
    {
        return in_array($code, $this->features);
    }

    public function includeFeature(string $code)
    {
        if(! $this->hasFeature($code)) {
            $this->features[] = $code;
        }
    }

    public function excludeFeature(string $code)
    {
        foreach($this->features as $index => $compare) {
            if($compare === $code) {
                unset($this->features[$index]);
            }
        }
    }

    public function listFeatures(): array
    {
        return $this->features;
    }

    public function __toString(): string
    {
        return implode(',', $this->features);
    }
}