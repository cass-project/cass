<?php
/**
 * Created by PhpStorm.
 * User: CoffeeTurbo
 * Date: 13.03.2016
 * Time: 17:15
 */

namespace Data\Repository\Channel\Parameters;


use Application\Tools\RequestParams\Param;
use Data\Repository\Channel\SaveChannelProperties;

class CreateChannelParemeters implements SaveChannelProperties
{

	/** @var Param */
	private $name;

	/** @var Param */
	private $description;

	/** @var Param */
	private $status;

	/** @var Param */
	private $account_id;

	/** @var Param */
	private $theme_id;
	/** @var Param */
	private $created;

	/** @var Param */
	private $updated;

	public function __construct(Param $name, Param $description, Param $status,
															 Param $theme_id)
	{
		$this->name = $name;
		$this->description = $description;
		$this->status = $status;
		$this->theme_id = $theme_id;


		$this->created = new \DateTime();
		$this->updated = $this->created ;
	}


	/**
	 * @return Param
	 */
	public function getCreated(){
		return $this->created;
	}

	/**
	 * @return Param
	 */
	public function getUpdated(){
		return $this->updated;
	}
	/**
	 * @return Param
	 */
	public function getName():Param{
		return $this->name;
	}

	/**
	 * @return Param
	 */
	public function getDescription():Param{
		return $this->description;
	}

	/**
	 * @return Param
	 */
	public function getStatus():Param{
		return $this->status;
	}

	/**
	 * @return Param
	 */
	public function getAccountId():Param{
		return $this->account_id;
	}

	public function setAccountId(Param $account_id){
		$this->account_id = $account_id;
		return $this;
	}

	/**
	 * @return Param
	 */
	public function getThemeId():Param{
		return $this->theme_id;
	}



}