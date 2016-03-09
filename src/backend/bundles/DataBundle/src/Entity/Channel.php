<?php
/**
 * User: юзер
 * Date: 09.03.2016
 * Time: 15:45
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Entity;

/**
 * @Entity(repositoryClass="Data\Repository\ChannelRepository")
 * @Table(name="channel")
 */
class Channel
{

	private $id;
	private $name;
	private $description;
	private $created;
	private $updated;
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