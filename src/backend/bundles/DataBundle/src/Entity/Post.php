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
	private $attachment;
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
	public function getAttachment(){
		return $this->attachment;
	}

	/**
	 * @param mixed $attachment
	 */
	public function setAttachment($attachment){
		$this->attachment = $attachment;
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
	public function getCreated(){
		return $this->created;
	}

	/**
	 * @param mixed $created
	 */
	public function setCreated($created){
		$this->created = $created;
	}

	/**
	 * @return mixed
	 */
	public function getUpdated(){
		return $this->updated;
	}

	/**
	 * @param mixed $updated
	 */
	public function setUpdated($updated){
		$this->updated = $updated;
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

	public function toJSON()
	{
		return [
			'id'          => $this->getId(),
			'name'        => $this->getName(),
			'description' => $this->getDescription(),
			'status'      => $this->getStatus()
		];
	}



}