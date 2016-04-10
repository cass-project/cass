<?php


namespace Data\Repository\Post;


use Common\Tools\RequestParams\Param;

interface SavePostProperties
{
	public function getName():Param;

	public function getDescription():Param;

	public function getPublish():Param;

	public function getAccountId():Param;

	public function getCreated():Param;

	public function getUpdated():Param;
}