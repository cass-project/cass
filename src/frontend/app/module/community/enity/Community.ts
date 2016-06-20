export class CommunityEnity {
    id: number;
    sid: string;
    date_created_on: Date;
    title: string;
    theme: {
        has:boolean,
        id:number
    };
    image: CommunityEnityImage;
    description: string;

    collections: {
        collection_id: number;
        position: number;
        sub: {}
    }[];

    public_options:{
        public_enabled: boolean,
        moderation_contract: boolean
    }
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