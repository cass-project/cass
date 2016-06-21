import {Success200} from "../../../common/definitions/common";

export interface SetPublicOptionsRequest
{
    is_private: boolean;
    public_enabled: boolean;
    moderation_enabled: boolean;
}

export interface SetPublicOptionsResponse200 extends Success200 {}