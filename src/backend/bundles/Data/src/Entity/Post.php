<?php

namespace Data\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity(repositoryClass="Data\Repository\Post\PostRepository")
 * @Table(name="post")
 */
class Post
{
	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $id;

	private $account;



	/**
	 * @account_id
	 * @Column(type="integer")
	 * @var int
	 */
	private $account_id;


	/**
	 * @OneToMany(targetEntity="Data\Entity\Attachment", mappedBy="post")
	 */
	private $attachments=[];
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $title;
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $description;
	/**
	 * @Column(type="datetime")
	 */
	private $created;
	/**
	 * @Column(type="datetime")
	 */
	private $updated;
	/**
	 * @Column(type="boolean")
	 */
	private $is_published;

	public function __construct() {
		$this->attachments = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId(int $id){
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getAccount(){
		return $this->account;
	}

	/**
	 * @param mixed $account
	 */
	public function setAccount($account){
		$this->account = $account;
	}

	/**
	 * @return mixed
	 */
	public function getAccountId(){
		return $this->account_id;
	}

	/**
	 * @param mixed $account_id
	 */
	public function setAccountId($account_id){
		$this->account_id = $account_id;
	}

	/**
	 * @return mixed
	 */
	public function getAttachments():array
	{
		return $this->attachments;
	}

	/**
	 * @param mixed $attachments
	 */
	public function setAttachments($attachments){
		$this->attachments = $attachments;
	}

	public function addAttachment(Attachment $attachment)
	{
		$this->attachments[] = $attachment;
		return $this;
	}
	public function removeAttachment(Attachment $attachment)
	{
		$this->attachments->removeElement($attachment);
	}

	/**
	 * @return string
	 */
	public function getTitle(){
		return $this->title;
	}


	/**
	 * @param $title
	 *
	 * @return $this
	 */
	public function setTitle($title){
		$this->title = $title;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description){
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getCreated():\DateTime{
		return $this->created;
	}

	/**
	 * @param \DateTime $created
	 *
	 * @return $this
	 */
	public function setCreated(\DateTime $created){
		$this->created = $created;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getUpdated():\DateTime{
		return $this->updated;
	}

	/**
	 * @param \DateTime $updated
	 *
	 * @return $this
	 */
	public function setUpdated(\DateTime $updated){
		$this->updated = $updated;
		return $this;
	}


	public function isPublished(){
		return $this->is_published;
	}


	public function setPublished($publish){
		$this->is_published = $publish;
		return $this;
	}

	public function toJSON()
	{

		$attachments = $this->attachments->map(function(Attachment $attachment) {
			return $attachment->toJSON();
		});

		return [
			'id'          => $this->getId(),
			'title'       => $this->getTitle(),
			'description' => $this->getDescription(),
			'publish'     => $this->isPublished(),
			'account_id'  => $this->getAccountId(),
			'attachments'	=> $attachments->toArray(),
			'created'     => $this->getCreated()->format("Y-m-d H:i:s"),
			'updated'     => $this->getUpdated()->format("Y-m-d H:i:s")
		];
	}



}