import {Success200, NotFound404} from "../../../common/definitions/common";
import {FeedbackEntity} from "../entity/Feedback";

export interface CreateFeedbackRequest
{
    profile_id: number;
    type_feedback: number;
    description: string;
}

export interface CreateCommunityResponse200 extends Success200
{
    entity: FeedbackEntity;
}

export interface CreateCommunityResponse404 extends NotFound404
{
}
