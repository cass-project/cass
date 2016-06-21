import {Success200} from "../../../common/definitions/common";
import {ColorEntity} from "../entity/Color";

export interface GetColorsResponse200 extends Success200
{
    colors: ColorEntity[];
}