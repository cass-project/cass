<?php
/**
 * User: юзер
 * Date: 16.03.2016
 * Time: 16:34
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Repository\Channel\Parameters;


use Application\Tools\RequestParams\Param;
use Data\Repository\Channel\SaveChannelProperties;

class UpdateChannelParameters implements SaveChannelProperties
{
	/** @var Param */
	private $id;


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

	public function __construct(int $id, Param $name, Param $description, Param $status,
															Param $account_id, Param $theme_id)
	{
		$this->id = $id;
		$this->name = $name;
		$this->description = $description;
		$this->status = $status;
		$this->account_id = $account_id;
		$this->theme_id = $theme_id;

		$this->updated = (new \DateTime())->format("Y-m-d");
	}

	/**
	 * @return Param
	 */
	public function getId(){
		return $this->id;
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

	/**
	 * @return Param
	 */
	public function getThemeId():Param{
		return $this->theme_id;
	}
}