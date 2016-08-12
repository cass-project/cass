<?php
namespace Domain\PostAttachment\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Post\Entity\Post;
use Domain\PostAttachment\Entity\PostAttachment;
use Domain\PostAttachment\Exception\PostAttachmentFactoryException;
use Domain\PostAttachment\Exception\PostAttachmentNotFoundException;

class PostAttachmentRepository extends EntityRepository
{
    public function makePostAttachmentEntity(): PostAttachment {
        $postAttachment = new PostAttachment();

        $this->getEntityManager()->persist($postAttachment);
        $this->getEntityManager()->flush($postAttachment);

        return $postAttachment;
    }

    public function createPostAttachment(PostAttachment $postAttachment) {
        $this->getEntityManager()->persist($postAttachment);
        $this->getEntityManager()->flush($postAttachment);
    }

    public function savePostAttachment(PostAttachment $postAttachment) {
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
    
    public function getPostAttachmentById(int $postAttachmentId): PostAttachment
    {
        $result = $this->find($postAttachmentId);
        
        if($result === null) {
            throw new PostAttachmentFactoryException(sprintf('Post attachment with ID `%s` not found', $postAttachmentId));
        }

        return $result;
    }

    public function getAttachmentByIds(array $ids): array
    {
        /** @var PostAttachment[] $result */
        $result = $this->findBy(['id' => array_filter($ids, function($input) {
            return is_int($input);
        })]);

        if(count($result) !== count($ids)) {
            throw new PostAttachmentNotFoundException(sprintf('Some of PostAttachment(ids: `%s`) not found', json_encode($ids)));
        }

        return $result;
    }

    public function getTotalCountAttachments(array $types):int
    {
        return $this->createQueryBuilder('a')
                    ->select('count(a.id)')
                    ->where('a.attachmentType IN (:types)')
                    ->setParameter('types', $types)
                    ->getQuery()
                    ->getSingleScalarResult();
    }

    public function getAttachmentsOfPost(int $postId): array
    {
        return $this->findBy([
            'post' => $postId
        ]);
    }
}