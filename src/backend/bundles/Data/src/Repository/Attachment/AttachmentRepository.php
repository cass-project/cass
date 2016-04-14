<?php
namespace Data\Repository\Attachment;

use Data\Entity\Attachment;
use Data\Entity\Post;
use Data\Repository\Post\CreateAttachmentParameters;
use Doctrine\ORM\EntityRepository;

class AttachmentRepository extends EntityRepository
{
	public function create(CreateAttachmentParameters $createAttachmentParameters):Attachment
	{

		$em = $this->getEntityManager();

		$attachmentEntity = new Attachment();

		$this->setupEntity($attachmentEntity, $createAttachmentParameters);

		$em->persist($attachmentEntity);
		$em->flush($attachmentEntity);

		return $attachmentEntity;
	}

	public function delete(int $id)
	{
		$em = $this->getEntityManager();
		$Entity = $this->createQueryBuilder('e')
													->select('e')
													->where('e.id = :id')
													->setParameter('id', $id)
													->getQuery()
													->getSingleResult();

		$em->remove($Entity);
		$em->flush();

		return $Entity;
	}


	public function setupEntity(Attachment $attachment,  SaveAttachmentProperties $saveAttachmentProperties )
	{
		$saveAttachmentProperties->getContent()->on(function($value) use($attachment) {
			$attachment->setContent($value);
		});

		$saveAttachmentProperties->getPostId()->on(function($value) use($attachment) {

			$repository =	$this->getEntityManager()->getRepository(Post::class);
			/** @var Post $post */
			$post = $repository->find($value);
			$attachment->setPost($post);
		});

		$saveAttachmentProperties->getUrl()->on(function($value) use($attachment) {
			$attachment->setUrl($value);
		});

		$saveAttachmentProperties->getContent()->on(function($value) use($attachment) {
			$attachment->setContent($value);
		});

		$saveAttachmentProperties->getPostId()->on(function($value) use($attachment) {
			if(!empty($value)){
				/** @var $Post Post */
				$Post = $this->getEntityManager()->getRepository(Post::class)->find($value);
				$attachment->setPostId($Post->getId());
				$attachment->setPost($Post);
			}
		});
		if($saveAttachmentProperties instanceof CreateAttachmentParameters){
			$saveAttachmentProperties->getUpdated()->on(function($value) use($attachment) {
				$attachment->setUpdated($value);
			});
			$saveAttachmentProperties->getCreated()->on(function($value) use($attachment) {
				$attachment->setCreated($value);
			});
		}

	}
}