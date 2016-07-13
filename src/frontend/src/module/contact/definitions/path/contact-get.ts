import {Success200} from "../../../common/definitions/common";
import {ContactEntity} from "../entity/Contact";

export interface ContactGetResponse200 extends Success200
{
    entity: ContactEntity;
}