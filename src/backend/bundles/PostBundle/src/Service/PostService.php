<?php
/**
 * User: юзер
 * Date: 18.03.2016
 * Time: 15:11
 * To change this template use File | Settings | File Templates.
 */

namespace Post\Service;


class PostService
{
	private $postRepository;

	/**
	 * @return mixed
	 */
	public function getPostRepository(){
		return $this->postRepository;
	}

	/**
	 * @param mixed $postRepository
	 */
	public function setPostRepository($postRepository){
		$this->postRepository = $postRepository;
	}
	public function create(){}
	public function update(){}
}