<?php
namespace CASS\Domain\Bundles\Profile\Doctrine;

use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Card\ProfileCard;
use CASS\Domain\Bundles\Profile\Entity\Card\Values\ProfileCardValue;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class ProfileCardDoctrineType extends Type
{
    const TYPE_NAME = 'cass_domain_profile_card';

    public function getName()
    {
        return self::TYPE_NAME;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getJsonTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value instanceof ProfileCard) {
            return json_encode($value->toJSON());
        }else{
            return '[]';
        }
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return new ProfileCard([], []);
        }

        $value = json_decode((is_resource($value)) ? stream_get_contents($value) : $value, true);

        return new ProfileCard(
            /* $access = */ array_map(function(string $key) use ($value) {
                return new ProfileCardAccess($key, $value['access'][$key]);
            }, array_keys($value['access'])),

            /* $values = */ array_map(function(string $key) use ($value) {
                return new ProfileCardValue($key, $value['values'][$key]);
            }, array_keys($value['values']))
        );
    }
}