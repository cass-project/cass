<?php
namespace CASS\Application\Frontline\Service\FrontlineService;

use CASS\Application\Frontline\FrontlineScript;

class ExcludeFilter implements Filter
{
    private $tags = [];

    public function exclude(array $tags) {
        $this->tags = array_merge($this->tags, $tags);
    }

    public function filter(array $scripts): array {
        if(count($this->tags) === 0) {
            return $scripts;
        }else{
            return array_filter($scripts, function(FrontlineScript $script) {
                return count(array_intersect($this->tags, $script->tags())) === 0;
            });
        }
    }
}