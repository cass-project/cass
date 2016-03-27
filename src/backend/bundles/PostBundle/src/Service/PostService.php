<?php

namespace Post\Service;


use Data\Entity\Post;
use Data\Repository\Post\Parameters\CreatePostParameters;
use Data\Repository\Post\Parameters\UpdatePostParameters;
use Data\Repository\Post\PostRepository;

class PostService
{
	private $postRepository;

	public function __construct(PostRepository $postRepository)
	{
		$this->postRepository = $postRepository;
	}

	/**
	 * @return PostRepository
	 */
	public function getPostRepository():PostRepository{
		return $this->postRepository;
	}

	/**
	 * @param PostRepository $postRepository
	 */
	public function setPostRepository(PostRepository $postRepository){
		$this->postRepository = $postRepository;
	}

	public function create(CreatePostParameters $createPostParameters):Post
	{
		return $this->getPostRepository()->create($createPostParameters);
	}

	public function update(UpdatePostParameters $updatePostParameters):Post
	{
		return $this->getPostRepository()->update($updatePostParameters);
	}


	public function getLinkOptions($link){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $link);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if(($rawHTML = curl_exec($ch)) === false) {
			return new \Exception("bad url request");
		}

		libxml_use_internal_errors(true);

		$doc = new \DOMDocument();
		$doc->loadHTML($rawHTML);

		$domXPATH = new \DOMXPath($doc);
		$opts = [
			'title'       => '',
			'url'         => $link,
			'image'       => FALSE,
			'description' => ''
		];

		$titleTag = $domXPATH->query('//title');
		$titleMetaTag = $domXPATH->query('//meta[@property="og:title"]');
		$urlMetaTag = $domXPATH->query('//meta[@property="og:url"]');
		$imageMetaTag = $domXPATH->query('//meta[@property="og:image"]');
		$descriptionMetaTag = $domXPATH->query('//meta[@property="og:description"]');

		if($titleMetaTag->length){
			$opts['title'] = $titleMetaTag->item(0)->attributes->getNamedItem('content')->nodeValue;
		}else if($titleTag->length){
			$opts['title'] = $titleTag->item(0)->textContent;
		}

		if($urlMetaTag->length){
			$opts['url'] = $urlMetaTag->item(0)->attributes->getNamedItem('content')->nodeValue;
		}

		if($imageMetaTag->length){
			$opts['image'] = $imageMetaTag->item(0)->attributes->getNamedItem('content')->nodeValue;
		}

		if($descriptionMetaTag->length){
			$opts['description'] = $descriptionMetaTag->item(0)->attributes->getNamedItem('content')->nodeValue;
		}

		return $opts;
	}

}