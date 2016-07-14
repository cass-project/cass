import {Success200} from "../../../common/definitions/common";
import {ContactEntity} from "../entity/Contact";

export interface ContactCreateRequest
{
    profile_id: number;
}

export interface ContactCreateResponse200 extends Success200
{
    entity: ContactEntity;
}