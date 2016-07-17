import {ImageCollection} from "../../../avatar/definitions/ImageCollection";

export interface CollectionEntity
{
    id: number;
    sid: string;
    owner_sid: string;
    owner: CollectionOwnerEntity;
    date_created_on: string;
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

export class Collection implements CollectionEntity
{
    static OWNER_TYPES = ['community', 'profile'];

    id: number;
    sid: string;
    owner_sid: string;
    owner: CollectionOwnerEntity;
    title: string;
    description: string;
    theme_ids: Array<number>;
    public_options: CollectionPublicOptionsEntity;
    image: ImageCollection;
    children: CollectionEntity[] = [];

    constructor(ownerType: string, ownerId: string) {
        if(!~Collection.OWNER_TYPES.indexOf(ownerType)) {
            throw new Error(`Unknown owner "${ownerType}"`)
        }

        this.title = '';
        this.description = '';
        this.owner_sid = `${ownerType}:${ownerId}`;
        this.owner = {
            id: ownerId,
            type: ownerType
        };
        this.theme_ids = [];
    }

    hasThemeIds(): boolean {
        return this.theme_ids.length > 0;
    }
}