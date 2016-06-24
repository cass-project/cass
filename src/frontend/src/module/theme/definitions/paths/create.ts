import {Success200} from "../../../common/definitions/common";
import {Theme} from "../entity/Theme";

export interface CreateThemeRequest
{
    parent_id: number;
    title: string;
    description: string;
}

export interface CreateThemeResponse200 extends Success200
{
    entity: Theme;
}