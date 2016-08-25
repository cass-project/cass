<?php
namespace CASS\Util\Entity\SIDEntity;

use CASS\Util\GenerateRandomString;

trait SIDEntityTrait
{
    /**
     * @Column(name="sid", type="string")
     * @var string
     */
    private $sid;

    public function getSID(): string
    {
        return $this->sid;
    }

    public function regenerateSID(): string
    {
        $this->sid = GenerateRandomString::gen(SIDEntity::SID_LENGTH);

        return $this->sid;
    }
}