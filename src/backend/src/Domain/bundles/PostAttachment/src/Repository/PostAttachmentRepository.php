<?php
namespace Domain\PostAttachment\Repository;

use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Domain\Post\Entity\Post;
use Domain\PostAttachment\Entity\PostAttachment;

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

    public function deletePostAttachments(array $attachments)
    {
        foreach($attachments as $attachment) {
            $this->getEntityManager()->remove($attachment);
        }
        $this->getEntityManager()->flush();
    }

    public function assignAttachmentsToPost(Post $post, array $attachmentIds) {
        /** @var PostAttachment[] $attachments */
        $attachments = $this->findBy([
            'id' => $attachmentIds
        ]);

        foreach($attachments as $attachment) {
            $attachment->attachToPost($post);
        }

        $this->getEntityManager()->flush($attachments);
    }

    public function getUnattachedAttachments(\DateTime $timeInterval) : array
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $queryBuilder
            ->select('a')
            ->from(PostAttachment::class, 'a')
            ->where('a.isAttachedToPost = :isAttachedToPost')
            ->andWhere('a.post IS NULL')
            ->andWhere('a.dateCreatedOn > :timeInterval')
                ->setParameter("isAttachedToPost", false)
                ->setParameter("timeInterval", $timeInterval)
        ;
        return $queryBuilder->getQuery()->getResult();
    }
}