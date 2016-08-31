<?php
namespace CASS\Application\Bundles\Frontline\Service\FrontlineService;

use CASS\Application\Bundles\Frontline\FrontlineScript;

class IncludeFilter implements Filter
{
    private $tags = [];

    public function includeTags(array $tags) {
        $this->tags = array_merge($this->tags, $tags);
    }

    public function filter(array $scripts): array {
        if(count($this->tags) === 0) {
            return $scripts;
        }else{
            return array_filter($scripts, function(FrontlineScript $script) {
                return count(array_intersect($this->tags, $script->tags())) > 0;
            });
        }
    }
}