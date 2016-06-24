import {Success200} from "../../../common/definitions/common";
import {Theme} from "../entity/Theme";

export interface ListTreeResponse200 extends Success200
{
    entities: Theme[];
}