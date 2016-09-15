import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Source, FeedResponse} from "../../source";
import {FeedRESTService} from "../../../FeedRESTService";
import {FeedRequest} from "../../../../definitions/request/FeedRequest";

@Injectable()
export class PublicCollectionsSource implements Source
{
    public collectionId: number;

    constructor(private feed: FeedRESTService) {}

    fetch(request: FeedRequest): Observable<FeedResponse> {
        return this.feed.getPublicCollectionsFeed(request);
    }
}