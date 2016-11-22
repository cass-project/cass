import {ImageCollection} from "../../../avatar/definitions/ImageCollection";
import {Backdrop} from "../../../backdrop/definitions/Backdrop";

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
    backdrop: Backdrop<any>;
    is_protected: boolean;
    is_main: boolean;
    children?: CollectionEntity[];
    subscribed: boolean;
}

export interface CollectionIndexEntity extends CollectionEntity
{
    _id: string;
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

// ?

export class Collection implements CollectionEntity
{
    static OWNER_TYPES = ['community', 'profile'];

    id: number;
    sid: string;
    owner_sid: string;
    date_created_on: string;
    owner: CollectionOwnerEntity;
    title: string;
    description: string;
    is_protected: boolean;
    is_main: boolean;
    theme_ids: Array<number>;
    public_options: CollectionPublicOptionsEntity;
    image: ImageCollection;
    backdrop: Backdrop<any>;
    children: CollectionEntity[] = [];
    subscribed: boolean;

    constructor(ownerType: string, ownerId: string, themeIds?: number) {
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
        this.theme_ids = !!themeIds ? [themeIds] : [];
    }

    hasThemeIds(): boolean {
        return this.theme_ids.length > 0;
    }
}