import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import {CommunityPublicOptionsEntity} from "./CommunityPublicOptions";

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