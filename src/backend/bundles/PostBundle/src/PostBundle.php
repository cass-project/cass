<?php
namespace Post;

use Application\Bootstrap\Bundle\GenericBundle;

class PostBundle extends GenericBundle
{
	public function getDir(){
		return __DIR__;
	}
}