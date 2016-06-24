export interface CommunityEditRequestModel {
    community: {
        title: string,
        description: string,
        theme_id: number
    };

    public_options: {
        public_enabled: boolean,
        moderation_contract: boolean
    }
}