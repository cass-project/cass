<?php
namespace CASS\Domain\Bundles\Profile\Entity\Card;

use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccessManager;
use CASS\Domain\Bundles\Profile\Entity\Card\Values\ProfileCardValue;
use CASS\Domain\Bundles\Profile\Entity\Card\Values\ProfileCardValuesManager;
use CASS\Util\JSONSerializable;

final class ProfileCard implements JSONSerializable
{
    /** @var ProfileCardAccessManager */
    private $access;

    /** @var ProfileCardValuesManager */
    private $values;

    public function __construct(array $access = [], array $values = [])
    {
        $this->access = new ProfileCardAccessManager($access);
        $this->values = new ProfileCardValuesManager($values);
    }

    public function toJSON(): array
    {
        $access = array_map(function(ProfileCardAccess $access) { return $access->toJSON(); }, $this->access->getAll());
        $values = array_map(function(ProfileCardValue $value) { return $value->toJSON(); }, $this->values->getAll());

        return [
            'access' => array_combine(
                array_column($access, 'key'),
                array_column($access, 'level')
            ),
            'values' => array_combine(
                array_column($values, 'key'),
                array_column($values, 'value')
            ),
        ];
    }

    public function getAccessManager(): ProfileCardAccessManager
    {
        return $this->access;
    }

    public function getValuesManager(): ProfileCardValuesManager
    {
        return $this->values;
    }
}