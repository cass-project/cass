<?php
namespace Application\Profile\Middleware\Command;

use Application\Common\Exception\BadCommandCallException;
use Application\Profile\Exception\ImageIsNotASquareException;
use Application\Profile\Exception\ImageTooBigException;
use Application\Profile\Exception\ImageTooSmallException;
use Psr\Http\Message\ServerRequestInterface;

class ImageUploadCommand extends Command
{
    public function run(ServerRequestInterface $request)
    {
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

            return [
                'profile_id' => $newProfileImage->getProfile()->getId(),
                'public_path' => $newProfileImage->getPublicPath()
            ];
        }catch(ImageTooSmallException $e) {
            throw new BadCommandCallException($e->getMessage());
        }catch(ImageTooBigException $e) {
            throw new BadCommandCallException($e->getMessage());
        }catch(ImageIsNotASquareException $e) {
            throw new BadCommandCallException($e->getMessage());
        }
    }
}