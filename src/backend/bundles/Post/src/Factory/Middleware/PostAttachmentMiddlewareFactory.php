<?php
namespace Post\Factory\Middleware;


use Auth\Service\CurrentAccountService;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Post\Middleware\AttachmentMiddleware;
use Post\Service\AttachmentService;
use Post\Service\PostService;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class PostAttachmentMiddlewareFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = NULL)
	{
		$postService = $container->get(PostService::class);
		$attachmentService = $container->get(AttachmentService::class);
		$currentAccountService = $container->get(CurrentAccountService::class);

		return new AttachmentMiddleware($postService, $attachmentService, $currentAccountService);
	}

}