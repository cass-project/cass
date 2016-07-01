import {ProfileEntity} from "../../../profile/definitions/entity/Profile";

export interface FeedbackEntity
{
    id: number;
    profile: {
        has: boolean,
        entity: ProfileEntity
    };
    created_at: string;
    type_feedback: number;
    description: string;
    read: boolean;
    email: {
        has: boolean,
        mail: string
    };
    answer: {
        has: boolean,
        entity: {
            created_at: {},
            description: string
        }
    }
}