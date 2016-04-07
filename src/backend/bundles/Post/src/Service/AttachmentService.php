<?php
namespace Post\Service;


use Data\Entity\Attachment;
use Data\Repository\Attachment\AttachmentRepository;
use Data\Repository\Post\CreateAttachmentParameters;

class AttachmentService
{

	/**
	 * @var AttachmentRepository
	 */
	private $attachmentRepository;
	public function __construct(AttachmentRepository $attachmentRepository)
	{
		$this->attachmentRepository = $attachmentRepository;
	}

	/**
	 * @return AttachmentRepository
	 */
	public function getAttachmentRepository():AttachmentRepository
	{
		return $this->attachmentRepository;
	}

	/**
	 * @param $attachmentRepository
	 *
	 * @return AttachmentService
	 */
	public function setAttachmentRepository($attachmentRepository):self
	{
		$this->attachmentRepository = $attachmentRepository;
		return $this;
	}

	public function create(CreateAttachmentParameters $createAttachmentParameters):Attachment
	{
		return $this->getAttachmentRepository()->create($createAttachmentParameters);
	}

}