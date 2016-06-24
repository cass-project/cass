import {Success200} from "../../../common/definitions/common";
import {Theme} from "../entity/Theme";

export interface GetThemeResponse200 extends Success200
{
    entity: Theme;
}