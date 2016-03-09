<?php
namespace Channel\Service;

use Data\Repository\ChannelRepository;

class ChannelService
{


	private $channelRepository;

	public function __construct($chanelRepository)
	{
		$this->channelRepository = $chanelRepository;
	}

	/**
	 * @return ChannelRepository
	 */
	public function getChannelRepository():ChannelRepository
	{
		return $this->channelRepository;
	}

	/**
	 * @param ChannelRepository $channelRepository
	 *
	 * @return ChannelService
	 */
	public function setChannelRepository(ChannelRepository $channelRepository):self
	{
		$this->channelRepository = $channelRepository;
		return $this;
	}







}