<?php
namespace Square\Service\Square;

class SquareService
{
    public function calculate($input) {
        if(!is_numeric($input)) {
            throw new InvalidInputException(sprintf('Input `%s` is not a number', $input));
        }

        return pow((int) $input, 2);
    }
}