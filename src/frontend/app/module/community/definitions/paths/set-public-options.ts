import {Success200} from "../../../common/definitions/common";

export interface SetPublicOptionsCommunityRequest
{
    "public_enabled": boolean;
    "moderation_contract": boolean;
}

export interface SetPublicOptionsCommunityResponse200 extends Success200
{
}