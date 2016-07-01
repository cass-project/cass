import {Injectable} from "angular2/core";
import {FeedbackCreateRequest} from "../../../definitions/paths/create";

@Injectable()
export class FeedbackCreateModalModel implements FeedbackCreateRequest
{
    profile_id: number;
    email: string;
    type_feedback: number;
    description: string;
}