import {Success200} from "../../../common/definitions/common";

export interface FeedbackCreateResponseRequest
{
    feedback_id: number;
    description: string;
}

export interface FeedbackCreateResponseResponse200 extends Success200 {

}