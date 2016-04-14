<?php
namespace Data\Entity;


use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @Entity(repositoryClass="Data\Repository\Attachment\AttachmentRepository")
 * @Table(name="attachment")
 */
class Attachment
{
	const TYPE_VIDEO_LINK = 1;

	/**
	 * @Id()
	 * @GeneratedValue
	 * @Column(type="integer")
	 * @var int
	 */
	private $id;

	/**
	 * @type
	 * @Column(type="integer")
	 */
	private $type;

	/**
	 * @ManyToOne(targetEntity="Data\Entity\Post", inversedBy="attachments")
	 * @JoinColumn(name="post_id", referencedColumnName="id")
	 */
	private $post;

	private $post_id;



	/**
	 * @Column(type="string")
	 */
	private $url;

	/**
	 * @Column(type="string")
	 */
	private $content;
	/**
	 * @Column(type="datetime")
	 */
	private $created;
	/**
	 * @Column(type="datetime")
	 */
	private $updated;


	public function getType()
	{
		return $this->type;
	}


	public function setType(int $type)
	{
		$this->type = $type;
		return $this;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
		return $this;
	}

	public function getPostId(){
		return $this->post_id;
	}

	public function setPostId($post_id){
		$this->post_id = $post_id;
		return $this;
	}

	/**
	 * @return Post
	 */
	public function getPost()
	{
		return $this->post;
	}


	public function setPost(Post $post)
	{
		$this->post = $post;
		return $this;
	}


	public function getContent()
	{
		return $this->content;
	}


	public function setContent($content)
	{
		$this->content = $content;
		return $this;
	}


	public function getCreated():\DateTime
	{
		return $this->created;
	}


	public function setCreated(\DateTime $created)
	{
		$this->created = $created;
		return $this;
	}


	public function getUpdated():\DateTime
	{
		return $this->updated;
	}

	public function setUpdated(\DateTime $updated)
	{
		$this->updated = $updated;
		return $this;
	}


	public function getId(){
		return $this->id;
	}


	public function setId($id){
		$this->id = $id;
	}

	public function toJSON()
	{
		return [
			'id'      => $this->id,
			'type'    => $this->type,
			'content' => $this->content,
			'created' => $this->getCreated()->format("Y-m-d H:i:s"),
			'updated' => $this->getUpdated()->format("Y-m-d H:i:s"),
		];
	}

}