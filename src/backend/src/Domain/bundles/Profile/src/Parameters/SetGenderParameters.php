<?php
namespace Domain\Profile\Parameters;

class SetGenderParameters
{
    /** @var string */
    private $genderStringCode;

    public function __construct(string $genderStringCode)
    {
        $this->genderStringCode = $genderStringCode;
    }

    public function getGenderStringCode(): string
    {
        return $this->genderStringCode;
    }
}