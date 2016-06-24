export interface CommunityEntity
{
    id: number;
    sid: string;
    date_created_on: string;
    title: string;
    description: string;
    image: CommunityEnityImage;
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

export interface CommunityPublicOptionsEntity
{
    public_enabled: boolean;
    moderation_contract: boolean;
}

export class CommunityEnityImage {
    uid: string;
    variants: {
        "16": {id: number, storage_path: string, public_path: string},
        "32": {id: number, storage_path: string, public_path: string},
        "64": {id: number, storage_path: string, public_path: string},
        "default": {id: number, storage_path: string, public_path: string}
    }
}