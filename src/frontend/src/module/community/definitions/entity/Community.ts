import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface CommunityEntity
{
    id: number;
    sid: string;
    date_created_on: string;
    title: string;
    description: string;
    image: ImageCollection;
    theme: {
        has:boolean,
        id?:number
    };
    collections: {
        collection_id: number;
        position: number;
        sub: {}
    }[];
    public_options: CommunityPublicOptionsEntity;
    features: string[];
}

export interface CommunityIndexedEntity extends CommunityEntity
{
    _id: string;
}

export interface CommunityPublicOptionsEntity
{
    public_enabled: boolean;
    moderation_contract: boolean;
}