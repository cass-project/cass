import {CommunityResponse200} from "./response";

export interface EditCommunityRequest
{
    title: string;
    description: string;
    theme_id?: number;
}

export interface EditCommunityResponse200 extends CommunityResponse200
{
}