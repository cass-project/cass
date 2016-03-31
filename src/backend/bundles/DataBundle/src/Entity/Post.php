<?php

namespace Data\Entity;

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
	private $attachments;
	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $name;
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
	 * @Column(type="string")
	 */
	private $status;

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
	public function getAttachments(){
		return $this->attachments;
	}

	/**
	 * @param mixed $attachments
	 */
	public function setAttachments($attachments){
		$this->attachments = $attachments;
	}

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name){
		$this->name = $name;
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

	/**
	 * @return mixed
	 */
	public function getStatus(){
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status){
		$this->status = $status;
	}

	public function addAttachment(Attachment $attachment)
	{
		$this->attachments[$attachment->getId()] = $attachment;
	}

	public function toJSON()
	{
		return [
			'id'          => $this->getId(),
			'name'        => $this->getName(),
			'description' => $this->getDescription(),
			'status'      => $this->getStatus(),
			'account_id'	=> $this->getAccountId(),
			'created'			=> $this->getCreated()->format("Y-m-d H:i:s"),
			'updated'			=> $this->getUpdated()->format("Y-m-d H:i:s")
		];
	}



}