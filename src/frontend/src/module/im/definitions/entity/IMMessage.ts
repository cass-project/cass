import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface IMMessageEntity
{
    id: string;
    author: ProfileEntity;
    date_created: string;
    content: string;
}