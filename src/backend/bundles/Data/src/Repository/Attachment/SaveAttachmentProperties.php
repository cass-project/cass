<?php
namespace Data\Repository\Attachment;


use Common\Tools\RequestParams\Param;

interface SaveAttachmentProperties
{
	public function getId():Param;

	public function getUrl():Param;

	public function getContent():Param;

	public function getPostId():Param;

}