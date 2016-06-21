import {Success200} from "../../../common/definitions/common";
import {Theme} from "../entity/Theme";

export interface ListAllThemesResponse200 extends Success200
{
    total: number;
    entities: Theme[];
}