<?php
namespace Post\Middleware\Command;
 
use Common\Exception\NotImplementedException;
use Post\Middleware\Request\EditPostRequest;
use Psr\Http\Message\ServerRequestInterface;

class EditPostCommand extends Command
{
    public function run(ServerRequestInterface $request) {
        $editPostParameters = (new EditPostRequest($request))->getParameters();
        
        throw new NotImplementedException;
    }
}