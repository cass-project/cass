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

    public function deletePostAttachments(array $postAttachments)
    {
        foreach($postAttachments as $postAttachment) {
            $this->getEntityManager()->remove($postAttachment);
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

    public function getUnattachedAttachments(int $timeInterval)
    {
        //$this->findBy()
    }
}