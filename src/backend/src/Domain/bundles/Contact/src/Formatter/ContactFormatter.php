<?php
namespace CASS\Domain\Bundles\Contact\Formatter;

use CASS\Domain\Bundles\Contact\Entity\Contact;
use CASS\Domain\Bundles\IM\Service\LastMessageService;

final class ContactFormatter
{
    /** @var LastMessageService */
    private $lastMessageService;

    public function __construct(LastMessageService $lastMessageService)
    {
        $this->lastMessageService = $lastMessageService;
    }

    public function format(Contact $contact): array
    {
        return array_merge($contact->toJSON(), [
            'last_message' => $this->lastMessageService->getLastMessage(new LastMessageService\LastMessageServiceQuery(
                $contact->getSourceProfile(),
                $contact->getTargetProfile()
            ))->toJSON()
        ]);
    }

    public function formatMany(array $contacts): array
    {
        $lastMessages = $this->lastMessageService->getLastMessages(array_map(function(Contact $contact) {
            return new LastMessageService\LastMessageServiceQuery(
                $contact->getSourceProfile(),
                $contact->getTargetProfile()
            );
        }, $contacts));

        return array_map(function(Contact $contact) use ($lastMessages) {
            return array_merge($contact->toJSON(), [
                'last_message' => array_shift($lastMessages)
            ]);
        }, $contacts);
    }
}