import {Injectable} from "angular2/core";

@Injectable()
export class FeedbackCreateModalModel
{
    profile_id: number;
    email: string;
    type_feedback: number;
    description: string;
}