import {CommunityEntity} from "./Community";

export interface CommunityIndexedEntity extends CommunityEntity
{
    _id: string;
}