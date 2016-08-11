export interface FrontlineCommunityFeaturesEntity
{
    code: string;
    fa_icon: string;
    is_development_ready: boolean;
    is_production_ready: boolean;
}

export interface CommunityFeatureEntity
{
    code: string;
    is_activated: boolean;
    disabled: boolean;
}