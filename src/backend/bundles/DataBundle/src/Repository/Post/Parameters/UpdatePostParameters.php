<?php

namespace Data\Repository\Post\Parameters;


use Application\Tools\RequestParams\Param;
use Data\Repository\SavePostProperties;

class UpdatePostParameters implements SavePostProperties
{
	private $name;
	private $description;
	private $status;

	public function __construct(Param $name, Param $description, Param $status){
		$this->name = $name;
		$this->description = $description;
		$this->status = $status;
	}

	public function getName():Param{
		return $this->name;
	}

	public function getDescription():Param{
		return $this->description;
	}

	public function getStatus():Param{
		return $this->status;
	}

}