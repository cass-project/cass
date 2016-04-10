<?php


namespace Data\Repository\Post;


use Common\Tools\RequestParams\Param;

interface SavePostProperties
{
	public function getTitle():Param;

	public function getDescription():Param;

	public function isPublished():Param;

	public function getAccountId():Param;

	public function getCreated():Param;

	public function getUpdated():Param;
}