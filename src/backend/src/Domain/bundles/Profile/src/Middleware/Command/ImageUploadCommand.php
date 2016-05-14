<?php
namespace Domain\Profile\Middleware\Command;

use Application\Exception\BadCommandCallException;
use Application\REST\Response\ResponseBuilder;
use Domain\Profile\Exception\ImageIsNotASquareException;
use Domain\Profile\Exception\ImageTooBigException;
use Domain\Profile\Exception\ImageTooSmallException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request, ResponseBuilder $responseBuilder): Response {
        try {
            $profileId = $this->validateProfileId($request->getAttribute('profileId'));

            $newProfileImage = $this->profileService->uploadImage(
                $profileId,
                $_FILES['file']['tmp_name'],
                $request->getAttribute('x1'),
                $request->getAttribute('y1'),
                $request->getAttribute('x2'),
                $request->getAttribute('y2')
            );

            return $responseBuilder
                ->setStatusSuccess()
                ->setJson([
                    'profile_id' => $newProfileImage->getProfile()->getId(),
                    'public_path' => $newProfileImage->getPublicPath()
                ])
                ->build();
        }catch(ImageTooSmallException $e) {
            throw new BadCommandCallException($e->getMessage());
        }catch(ImageTooBigException $e) {
            throw new BadCommandCallException($e->getMessage());
        }catch(ImageIsNotASquareException $e) {
            throw new BadCommandCallException($e->getMessage());
        }
    }

}