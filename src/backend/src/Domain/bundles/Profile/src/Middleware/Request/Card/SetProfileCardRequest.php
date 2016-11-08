<?php
namespace CASS\Domain\Bundles\Profile\Middleware\Request\Card;

use CASS\Domain\Bundles\Profile\Entity\Card\Access\ProfileCardAccess;
use CASS\Domain\Bundles\Profile\Entity\Card\ProfileCard;
use CASS\Domain\Bundles\Profile\Entity\Card\Values\ProfileCardValue;
use CASS\Domain\Bundles\Profile\ProfileBundle;
use ZEA2\Platform\Bundles\REST\Request\Params\SchemaParams;
use ZEA2\Platform\Bundles\REST\Service\JSONSchema;

final class SetProfileCardRequest extends SchemaParams
{
    public function getParameters(): ProfileCard
    {
        $card = $this->getData()['card'];

        return new ProfileCard(
            array_map(function(array $access) {
                return new ProfileCardAccess($access['key'], $access['level']);
            }, $card['access']),

            array_map(function(array $value) {
                return new ProfileCardValue($value['key'], $value['value']);
            }, $card['values'])
        );
    }

    protected function getSchema(): JSONSchema
    {
        return SchemaParams::getSchemaService()->getSchema(ProfileBundle::class, './definitions/request/Card/SetProfileCardRequest.yml');
    }
}