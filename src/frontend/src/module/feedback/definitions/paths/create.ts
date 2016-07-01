import {Success200} from "../../../common/definitions/common";
import {FeedbackEntity} from "../entity/Feedback";

export interface FeedbackCreateRequest
{
    profile_id: number;
    email?: string;
    type_feedback: number;
    description: string;
}

export interface FeedbackCreateResponse200 extends Success200
{
    entity: FeedbackEntity;
}