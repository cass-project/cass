<?php
namespace Channel\Service;

class ChannelService
{


	private $channelRepository;

	public function __construct($chanelRepository)
	{
		$this->channelRepository = $chanelRepository;
	}

	/**
	 * @return mixed
	 */
	public function getChannelRepository(){
		return $this->channelRepository;
	}

	/**
	 * @param mixed $channelRepository
	 */
	public function setChannelRepository($channelRepository):self
	{
		$this->channelRepository = $channelRepository;
		return $this;
	}







}