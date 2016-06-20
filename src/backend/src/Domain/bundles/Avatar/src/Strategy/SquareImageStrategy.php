<?php
namespace Domain\Avatar\Strategy;

use Domain\Avatar\Exception\ImageTooSmallException;
use Domain\Avatar\Exception\InvalidRatioException;
use Intervention\Image\Image;

abstract class SquareImageStrategy implements ImageStrategy
{
    const MIN_SIZE = 64;

    public function getDefaultSize(): int {
        return 64;
    }

    public function getSizes(): array {
        return [
            512,
            256,
            128,
            64,
            32,
            16
        ];
    }

    public function getRatio(): string {
        return "1:1";
    }

    public function validate(Image $origImage)
    {
        if($origImage->getWidth() !== $origImage->getHeight()) {
            throw new InvalidRatioException('Image should be a square');
        }

        if($origImage->getWidth() < self::MIN_SIZE) {
            throw new ImageTooSmallException(sprintf('Image should be more than %s px', self::MIN_SIZE));
        }
    }
}