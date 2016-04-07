<?php
namespace Data\Repository\Post\Parameters;
use Application\Tools\RequestParams\Param;
use Data\Repository\Post\SavePostProperties;

class CreatePostParameters implements SavePostProperties
{
	private $name;
	private $description;
	private $publish;
	private $accountId;

	public function __construct(Param $name, Param $description)
	{
		$this->name        = $name;
		$this->description = $description;
	}

	public function getName():Param
	{
		return $this->name;
	}

	public function getDescription():Param
	{
		return $this->description;
	}

	public function getPublish():Param
	{
		return $this->publish;
	}

	public function setPublish(Param $publish)
	{
		$this->publish = $publish;
		return $this;
	}

	public function getAccountId():Param
	{
		return $this->accountId;
	}

	public function setAccountId(Param $id)
	{
		$this->accountId = $id;
		return $this;
	}


	public function getCreated():Param
	{
		$updated['created'] = new \DateTime();
		return new Param($updated, 'created');
	}

	public function getUpdated():Param
	{
		$updated['updated'] = new \DateTime();
		return new Param($updated, 'updated');
	}
}