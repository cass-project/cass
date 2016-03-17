<?php
namespace Channel\Service;


use Data\Repository\Channel\ChannelRepository;
use Data\Repository\Channel\Parameters\CreateChannelParemeters;
use Data\Repository\Channel\Parameters\UpdateChannelParameters;

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


	public function create(CreateChannelParemeters $createChannelParemeters)
	{
		return $this->getChannelRepository()->create($createChannelParemeters);
	}

	public function update(UpdateChannelParameters $updateChannelParemeters){
		return $this->getChannelRepository()->update($updateChannelParemeters);
	}

}