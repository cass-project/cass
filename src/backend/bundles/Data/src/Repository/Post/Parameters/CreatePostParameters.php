<?php
namespace Data\Repository\Post\Parameters;
use Common\Tools\RequestParams\Param;
use Data\Repository\Post\SavePostProperties;

class CreatePostParameters implements SavePostProperties
{
	protected $title;
	protected $description;
	protected $is_published;
	protected $accountId;

	public function __construct(Param $title, Param $description)
	{
		$this->title        = $title;
		$this->description = $description;
	}

	public function getTitle():Param
	{
		return $this->title;
	}

	public function getDescription():Param
	{
		return $this->description;
	}

	public function isPublished():Param
	{
		return $this->is_published;
	}

	public function publish()
	{
		$this->is_published = new Param(['is_published'=> 1],'is_published');
		return $this;
	}

	public function unpublish()
	{
		$this->is_published = new Param(['is_published'=> 0],'is_published');
		return $this;
	}

	public function getAccountId():Param
	{
		return $this->accountId;
	}

	public function setAccountId($id)
	{
		if($id instanceof Param){
			$this->accountId = $id;
		}else {
			$this->accountId=	new Param(['account_id'=>$id], 'account_id');
		}
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