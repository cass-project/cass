import {Success200} from "../../../common/definitions/common";
import {ContactEntity} from "../entity/Contact";

export interface ContactListResponse200 extends Success200
{
    entities: ContactEntity[];
}