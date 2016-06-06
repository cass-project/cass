export class CommunityModel {
    id: number;
    sid: string;
    date_created_on: Date;
    title: string;
    description: string;
    theme_id: number;
    has_image: boolean;
    image: {
        public_path: string
    };
    collections: {
        collection_id: number;
        position: number;
        sub: {}
    }[];
    features: string[]
}
