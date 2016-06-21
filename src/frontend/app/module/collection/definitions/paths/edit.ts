import {Success200} from "../../../common/definitions/common";

export interface EditCollectionRequest
{
    title: string;
    description: string;
    theme_ids: Array<number>;
}

export interface EditCollectionResponse200 extends Success200 {}