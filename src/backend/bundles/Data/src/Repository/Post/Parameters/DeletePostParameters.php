<?php
namespace Data\Repository\Post\Parameters;



class DeletePostParameters
{

	private $postId;

	public function __construct(int $postId)
	{
		$this->postId = $postId;
	}

	public function getPostId():int
	{
		return $this->postId;
	}
}