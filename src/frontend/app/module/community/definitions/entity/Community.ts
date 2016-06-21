import {CollectionEntity} from "../../../collection/definitions/entity/collection";

export interface CommunityEntity
{
    id: number;
    sid: string;
    date_created_on: string;
    title: string;
    description: string;
    collections: CollectionEntity[];
    public_options: CommunityPublicOptionsEntity;
    features: string[];
}

export interface CommunityPublicOptionsEntity
{
    public_enabled: boolean;
    moderation_contract: boolean;
}
