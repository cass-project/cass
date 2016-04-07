<?php

namespace Post\Factory\Service;


use Data\Repository\Attachment\AttachmentRepository;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Service\AttachmentService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class AttachmentServiceFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL){

		$attachmentRepository = $container->get(AttachmentRepository::class);
		return new AttachmentService($attachmentRepository);
	}

}