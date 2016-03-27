<?php
namespace Data\Repository\Post;


use Data\Entity\Post;
use Data\Repository\Post\Parameters\CreatePostParameters;
use Data\Repository\Post\SavePostProperties;
use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
	public function create(CreatePostParameters $createPostParameters):Post
	{
		$postEntity = new Post();
		$this->setupEntity($postEntity, $createPostParameters);

		$em = $this->getEntityManager();
		$em->persist($postEntity);
		$em->flush();

		return $postEntity;
	}


	private function setupEntity(Post $postEntity, SavePostProperties $savePostProperties)
	{
		$savePostProperties->getName()->on(function($value) use($postEntity) {
			$postEntity->setName($value);
		});
		$savePostProperties->getDescription()->on(function($value) use($postEntity) {
			$postEntity->setDescription($value);
		});
		$savePostProperties->getStatus()->on(function($value) use($postEntity) {
			$postEntity->setStatus($value);
		});

		$savePostProperties->getAccountId()->on(function($value)use($postEntity){
			$postEntity->setAccountId($value);
		});

		$date = (new \DateTime());

		$postEntity->setCreated($date);
		$postEntity->setUpdated($date);
	}

}