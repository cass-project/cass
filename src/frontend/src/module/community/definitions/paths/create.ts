import {CommunityResponse200} from "./response";

export interface CreateCommunityRequest
{
    title: string;
    description: string;
    theme_id?: number;
}

export interface CreateCommunityResponse200 extends CommunityResponse200
{
}