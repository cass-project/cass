<?php
namespace PostAttachment\Repository;

use Doctrine\ORM\EntityRepository;
use PostAttachment\Entity\PostAttachment;

class PostAttachmentRepository extends EntityRepository
{
    public function makePostAttachmentEntity(string $attachmentType): PostAttachment {
        $postAttachment = new PostAttachment($attachmentType);

        $this->getEntityManager()->persist($postAttachment);
        $this->getEntityManager()->flush($postAttachment);

        return $postAttachment;
    }

    public function savePostAttachment(PostAttachment $postAttachment) {
        $this->getEntityManager()->persist($postAttachment);
        $this->getEntityManager()->flush($postAttachment);
    }
}