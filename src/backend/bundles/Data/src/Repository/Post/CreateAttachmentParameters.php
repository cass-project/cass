<?php
namespace Data\Repository\Post;


use Common\Tools\RequestParams\Param;
use Data\Repository\Attachment\SaveAttachmentProperties;

class CreateAttachmentParameters implements SaveAttachmentProperties
{
	private $id;
	private $post_id;
	private $url;


	private $content;

	/**
	 * @param Param $post_id
	 * @param Param $url
	 */
	public function __construct(Param $post_id, Param $url)
	{
		$this->post_id = $post_id;
		$this->url    = $url;
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
	public function getUrl():Param
	{
		return $this->url;
	}


	/**
	 * @param Param $url
	 *
	 * @return $this
	 */
	public function setUrl(Param $url){
		$this->url = $url;
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