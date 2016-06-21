import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface CollectionEntity
{
    id: number;
    sid: string;
    owner_sid: string;
    owner: CollectionOwnerEntity;
    title: string;
    description: string;
    theme_ids: Array<number>;
    public_options: CollectionPublicOptionsEntity;
    image: ImageCollection;
    children?: CollectionEntity[];
}

export interface CollectionOwnerEntity
{
    id: string;
    type: string;
}

export interface CollectionPublicOptionsEntity
{
    is_private: boolean;
    public_enabled: boolean;
    moderation_contract: boolean;
}