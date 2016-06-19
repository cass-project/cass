<?php
namespace Domain\Feedback\Middleware\Command;
use Application\Command\Command as CommandInterface;
use Application\REST\Response\ResponseBuilder;
use Psr\Http\Message\ServerRequestInterface;

abstract class Command implements CommandInterface
{

}