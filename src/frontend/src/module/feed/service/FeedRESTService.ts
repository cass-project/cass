import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Observable";
import {FeedRequest} from "../definitions/request/FeedRequest";
import {FeedResponse} from "./FeedService/source";

@Injectable()
export class FeedRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getProfileFeed(profileId: number, request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/profile/${profileId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getCommunityFeed(communityId: number, request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/community/${communityId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getCollectionFeed(collectionId: number, request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/collection/${collectionId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicCollectionsFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-collections/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicCommunitiesFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-communities/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicContentFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-content/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicDiscussionsFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-discussions/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicExpertsFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-experts/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getPublicProfilesFeed(request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/public-profiles/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }
}