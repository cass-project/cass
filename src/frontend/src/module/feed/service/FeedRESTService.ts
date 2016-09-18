import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {FeedRequest} from "../definitions/request/FeedRequest";
import {FeedResponse} from "./FeedService/source";
import {RESTService} from "../../common/service/RESTService";

export interface FeedRESTServiceInterface
{
    getProfileFeed(profileId: number, request: FeedRequest): Observable<FeedResponse>;
    getCommunityFeed(communityId: number, request: FeedRequest): Observable<FeedResponse>;
    getCollectionFeed(collectionId: number, request: FeedRequest): Observable<FeedResponse>;
    getPublicCollectionsFeed(request: FeedRequest): Observable<FeedResponse>;
    getPublicCommunitiesFeed(request: FeedRequest): Observable<FeedResponse>;
    getPublicContentFeed(request: FeedRequest): Observable<FeedResponse>;
    getPublicDiscussionsFeed(request: FeedRequest): Observable<FeedResponse>;
    getPublicExpertsFeed(request: FeedRequest): Observable<FeedResponse>;
    getPublicProfilesFeed(request: FeedRequest): Observable<FeedResponse>;
}

@Injectable()
export class FeedRESTService implements FeedRESTServiceInterface
{
    constructor(private rest: RESTService) {}

    getProfileFeed(profileId: number, request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/profile/${profileId}`, request);
    }

    getCommunityFeed(communityId: number, request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/community/${communityId}`, request);
    }

    getCollectionFeed(collectionId: number, request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/collection/${collectionId}`, request);
    }

    getPublicCollectionsFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-collections/`, request);
    }

    getPublicCommunitiesFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-communities/`, request);
    }

    getPublicContentFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-content/`, request);
    }

    getPublicDiscussionsFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-discussions/`, request);
    }

    getPublicExpertsFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-experts/`, request);
    }

    getPublicProfilesFeed(request: FeedRequest): Observable<FeedResponse> {
        return this.rest.post(`/backend/api/feed/get/public-profiles/`, request);
    }
}