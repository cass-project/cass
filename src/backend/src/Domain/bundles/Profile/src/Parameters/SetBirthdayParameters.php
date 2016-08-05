<?php
namespace Domain\Profile\Parameters;

final class SetBirthdayParameters
{
    /** @var \DateTime */
    private $date;

    public function __construct(\DateTime $date)
    {
        $this->date = $date;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }
}