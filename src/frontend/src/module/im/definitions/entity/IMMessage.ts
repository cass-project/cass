import {ProfileEntity} from "../../../profile/definitions/entity/Profile";
import {IMMessageReadStatus} from "./IMMessageReadStatus";

export interface IMMessageEntity
{
    id: string;
    author: ProfileEntity;
    date_created: string;
    read_status: IMMessageReadStatus;
    content: string;
}