import {Success200} from "../../../common/definitions/common";
import {FeedbackEntity} from "../entity/Feedback";

export interface FeedbackGetResponse200 extends Success200
{
    entity: FeedbackEntity;
}