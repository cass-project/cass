import {Success200} from "../../../common/definitions/common";
import {FeedbackEntity} from "../entity/Feedback";
export interface ListFeedbackQueryParams
{
    profileId?: number;
    read?: boolean;
    answer?: boolean;
}

export interface ListFeedbackResponse200 extends Success200
{
    entities: FeedbackEntity[];
}