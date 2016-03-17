<?php
/**
 * User: юзер
 * Date: 16.03.2016
 * Time: 17:05
 * To change this template use File | Settings | File Templates.
 */

namespace Data\Repository\Channel;


use Application\Tools\RequestParams\Param;

interface SaveChannelProperties
{


	function getName():Param;

	function getDescription():Param;

	function getStatus():Param;

	function getAccountId():Param;

	function getThemeId():Param;

	function getCreated():Param;

	function getUpdated():Param;

}