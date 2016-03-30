<?php
namespace Data\Repository\Attachment;

use Data\Entity\Attachment;
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


	public function setupEntity(Attachment $attachment,  SaveAttachmentProperties $saveAttachmentProperties )
	{
		$saveAttachmentProperties->getContent()->on(function($value) use($attachment) {
			$attachment->setContent($value);
		});

		$saveAttachmentProperties->getPostId()->on(function($value) use($attachment) {
			$attachment->setPostId($value);
		});

		$saveAttachmentProperties->getType()->on(function($value) use($attachment) {
			$attachment->setType($value);
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