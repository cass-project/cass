<?php

namespace Data\Repository\Post\Parameters;


use Common\Tools\RequestParams\Param;
use Data\Repository\Post\SavePostProperties;

class UpdatePostParameters extends CreatePostParameters implements SavePostProperties
{

	public function __construct(Param $title, Param $description, Param $is_published, Param $id){
		parent::__construct($title,$description);

		$this->id           = $id;
		$this->is_published = $is_published;
	}

	public function getId()
	{
		return $this->id;
	}
	public function isPublished()
	{
		return $this->is_published;
	}


}