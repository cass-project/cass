<?php
namespace Square\Service\Square;

class SquareService
{
    public function calculate($input) {
        return pow((int) $input, 2);
    }
}