<?php
namespace Data\Repository\Post;


use Data\Entity\Post;
use Data\Repository\Post\Parameters\CreatePostParameters;
use Data\Repository\Post\Parameters\UpdatePostParameters;
use Data\Repository\Post\SavePostProperties;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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

	public function update(UpdatePostParameters $updatePostParameters):Post
	{
		$postId=$updatePostParameters->getId()->value();

		$postEntity = $this->getPostEntity($postId);

		$this->setupEntity($postEntity, $updatePostParameters);
		$em = $this->getEntityManager();
		$em->persist($postEntity);
		$em->flush();
		return $postEntity;
	}

	public function delete(int $id):Post
	{
		$em = $this->getEntityManager();
		$postEntity = $this->getPostEntity($id);
		$em->remove($postEntity);
		$em->flush();
		return $postEntity;
	}

	public function getPost(int $id):array
	{
		return $this->createQueryBuilder('p')
								->select('p')
								->where('p.id = :id')
								->setParameter('id', $id)
								->getQuery()
								->getResult(Query::HYDRATE_ARRAY);
	}

	public function getPostEntity(int $id):Post
	{

		return $this->createQueryBuilder('p')
								->select('p')
								->where('p.id = :id')
								->setParameter('id', $id)
								->getQuery()
								->getSingleResult();
	}

	public function getPosts():array
	{
		return $this->createQueryBuilder('p')
								->select('p')
								->getQuery()
								->getResult(Query::HYDRATE_ARRAY);
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

		$savePostProperties->getCreated()->on(function($value)use($postEntity){
			$postEntity->setCreated($value);
		});

		$postEntity->setUpdated($date);
	}

}