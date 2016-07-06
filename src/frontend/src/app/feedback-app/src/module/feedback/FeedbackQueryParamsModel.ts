import {Injectable} from "angular2/core";

import {ListFeedbackQueryParams} from "../../../../../module/feedback/definitions/paths/list";

@Injectable()
export class FeedbackQueryModel implements ListFeedbackQueryParams {
    limit: number = 10;
    offset: number = 0;
    profileId: number = undefined;
    read: boolean = undefined;
    answer: boolean = undefined;
}