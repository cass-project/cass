<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 15:45
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\Channel\ChannelRepository")
 * @Table(name="channel")
 */
class Channel
{
	/**
	 * @Id
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $id;


	/**
	 * @Account_id
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $account_id;

	/**
	 * @Theme_id
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $theme_id;

	/**
	 * @Name
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
	 * @Column(type="string")
	 * @var string
	 */
	private $created;

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $updated;

	/**
	 * @Column(type="string")
	 * @var string
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
	public function setId($id){
		$this->id = $id;
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
	 * @return int
	 */
	public function getAccountId(){
		return $this->account_id;
	}

	/**
	 * @param int $account_id
	 */
	public function setAccountId($account_id){
		$this->account_id = $account_id;
	}

	/**
	 * @return int
	 */
	public function getThemeId(){
		return $this->theme_id;
	}

	/**
	 * @param int $theme_id
	 */
	public function setThemeId($theme_id){
		$this->theme_id = $theme_id;
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


}