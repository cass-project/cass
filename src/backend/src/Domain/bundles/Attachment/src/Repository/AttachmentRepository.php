<?php
namespace CASS\Domain\Attachment\Repository;

use Doctrine\ORM\EntityRepository;
use CASS\Domain\Attachment\Entity\Attachment;
use CASS\Domain\Attachment\Exception\AttachmentFactoryException;
use CASS\Domain\Attachment\Exception\AttachmentNotFoundException;

class AttachmentRepository extends EntityRepository
{
    public function createAttachment(Attachment $attachment)
    {
        $this->getEntityManager()->persist($attachment);
        $this->getEntityManager()->flush($attachment);
    }

    public function saveAttachment(Attachment $attachment)
    {
        $this->getEntityManager()->flush($attachment);
    }

    public function deleteAttachment(array $attachments)
    {
        foreach($attachments as $attachment) {
            $this->getEntityManager()->remove($attachment);
        }
        $this->getEntityManager()->flush();
    }

    public function getById(int $attachmentId): Attachment
    {
        $result = $this->find($attachmentId);

        if($result === null) {
            throw new AttachmentFactoryException(sprintf('Attachment with ID `%s` not found', $attachmentId));
        }

        return $result;
    }

    public function getManyByIds(array $ids): array
    {
        /** @var Attachment[] $result */
        $result = $this->findBy(['id' => array_filter($ids, function($input) {
            return is_int($input);
        })]);

        if(count($result) !== count($ids)) {
            throw new AttachmentNotFoundException(sprintf('Some of Attachment(ids: `%s`) not found',
                json_encode($ids)));
        }

        return $result;
    }
}