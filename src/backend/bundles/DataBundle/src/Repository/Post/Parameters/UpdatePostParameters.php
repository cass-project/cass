<?php

namespace Data\Repository\Post\Parameters;


use Application\Tools\RequestParams\Param;
use Data\Repository\Post\SavePostProperties;

class UpdatePostParameters implements SavePostProperties
{

	private $id;

	private $account_id;

	private $name;
	private $description;
	private $status;

	public function __construct(Param $name, Param $description, Param $status,Param $id){
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->status = $status;
	}
	/**
	 * @return Param
	 */
	public function getId():Param{
		return $this->id;
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

	public function getAccountId():Param{
		return $this->account_id;
	}

}