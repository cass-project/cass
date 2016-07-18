import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Observable";

import {Source, FeedResponse} from "../source";
import {FeedRESTService} from "../../FeedRESTService";
import {FeedRequest} from "../../../definitions/request/FeedRequest";

@Injectable()
export class CommunitySource implements Source
{
    public communityId: number;

    constructor(private feed: FeedRESTService) {}

    fetch(request: FeedRequest): Observable<FeedResponse> {
        return this.feed.getCommunityFeed(this.communityId, request);
    }
}