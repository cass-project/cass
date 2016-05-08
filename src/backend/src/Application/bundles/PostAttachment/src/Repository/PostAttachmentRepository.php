<?php
namespace Application\PostAttachment\Repository;

use Doctrine\ORM\EntityRepository;
use Application\Post\Entity\Post;
use Application\PostAttachment\Entity\PostAttachment;
use PostAttachment\Repository\string;

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
}