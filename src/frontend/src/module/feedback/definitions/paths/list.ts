import {Success200} from "../../../common/definitions/common";
import {FeedbackEntity} from "../entity/Feedback";

export interface FeedbackListResponse200 extends Success200
{
    entities: FeedbackEntity[];
}