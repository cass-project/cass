<?php
namespace Data\Repository\Post;


use Application\Tools\RequestParams\Param;
use Data\Repository\Attachment\SaveAttachmentProperties;

class CreateAttachmentParameters implements SaveAttachmentProperties
{
	private $id;
	private $post_id;
	private $type;
	private $content;

	public function __construct(Param $post_id, Param $type, Param $content)
	{
		$this->post_id = $post_id;
		$this->type    = $type;
		$this->content = $content;
	}

	/**
	 * @return Param
	 */
	public function getId():Param
	{
		return $this->id;
	}

	/**
	 * @param Param $id
	 *
	 * @return $this
	 */
	public function setId(Param $id)
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * @return Param
	 */
	public function getPostId():Param
	{
		return $this->post_id;
	}

	/**
	 * @param Param $post_id
	 *
	 * @return $this
	 */
	public function setPostId(Param $post_id)
	{
		$this->post_id = $post_id;
		return $this;
	}

	/**
	 * @return Param
	 */
	public function getType():Param
	{
		return $this->type;
	}

	/**
	 * @param Param $type
	 *
	 * @return $this
	 */
	public function setType(Param $type)
	{
		$this->type = $type;
		return $this;
	}


	/**
	 * @return Param
	 */
	public function getContent():Param
	{
		return $this->content;
	}


	/**
	 * @param Param $content
	 *
	 * @return $this
	 */
	public function setContent(Param $content)
	{
		$this->content = $content;
		return $this;
	}

	/**
	 * @return Param
	 */
	public function getCreated():Param
	{
		$date['created'] = new \DateTime();
		return new Param($date, 'created');
	}


	/**
	 * @return Param
	 */
	public function getUpdated():Param
	{
		$date['updated'] = new \DateTime();
		return new Param($date, 'updated');
	}
}