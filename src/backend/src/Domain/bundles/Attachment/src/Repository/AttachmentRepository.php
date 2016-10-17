<?php
namespace CASS\Domain\Bundles\Attachment\Repository;

use CASS\Util\Seek;
use Doctrine\ORM\EntityRepository;
use CASS\Domain\Bundles\Attachment\Entity\Attachment;
use CASS\Domain\Bundles\Attachment\Exception\AttachmentFactoryException;
use CASS\Domain\Bundles\Attachment\Exception\AttachmentNotFoundException;

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

    public function listAttachments(Seek $criteria): array
    {
        $qb = $this->createQueryBuilder('a');
        $qb->setFirstResult($criteria->getOffset());
        $qb->setMaxResults($criteria->getLimit());

        /** @var Attachment[] $result */
        $result = $qb->getQuery()->execute();

        return $result;
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