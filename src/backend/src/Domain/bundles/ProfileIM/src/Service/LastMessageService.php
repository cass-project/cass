<?php
namespace Domain\ProfileIM\Service;

use Domain\ProfileIM\Service\LastMessageService\LastMessageServiceQuery;
use Domain\ProfileIM\Service\LastMessageService\LastMessageServiceResult;

final class LastMessageService
{
    public function getLastMessage(LastMessageServiceQuery $query)
    {
        return new LastMessageServiceResult(true, new \DateTime(), "Last message <NOT_IMPLEMENTED>");
    }

    public function getLastMessages(array $definitions)
    {
        /** @var LastMessageServiceResult[] $result */
        $result = array_map(function(LastMessageServiceQuery $query) {
            return $this->getLastMessage($query);
        }, $definitions);

        return $result;
    }
}