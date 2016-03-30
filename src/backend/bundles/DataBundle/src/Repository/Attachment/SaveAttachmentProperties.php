<?php
namespace Data\Repository\Attachment;


use Application\Tools\RequestParams\Param;

interface SaveAttachmentProperties
{
	public function getId():Param;

	public function getType():Param;

	public function getContent():Param;

	public function getPostId():Param;

}