import {Theme} from "../entity/Theme";
import {Success200} from "../../../common/definitions/common";

export interface MoveThemeRequest
{
    parent_theme_id: number;
    position: number;
}

export interface MoveThemeResponse200 extends Success200
{
    entity: Theme;
}