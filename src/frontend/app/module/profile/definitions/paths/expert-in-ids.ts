import {Success200} from "../../../common/definitions/common";

export interface ExpertInRequest
{
    theme_ids: number[];
}

export interface ExpertInResponse200 extends Success200 {}