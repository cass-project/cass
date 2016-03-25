<?php


namespace Data\Repository\Post;


use Application\Tools\RequestParams\Param;

interface SavePostProperties
{
	public function getName():Param;
	public function getDescription():Param;
	public function getStatus():Param;
}