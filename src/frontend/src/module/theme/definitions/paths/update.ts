import {Success200} from "../../../common/definitions/common";
import {Theme} from "../entity/Theme";

export interface UpdateThemeRequest
{
    title: string;
    description: string;
}

export interface UpdateThemeResponse200 extends Success200
{
    entity: Theme;
}