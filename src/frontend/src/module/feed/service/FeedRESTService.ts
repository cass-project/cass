import {Injectable} from "angular2/core";
import {Http} from "angular2/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Observable";
import {FeedRequest} from "../definitions/request/FeedRequest";
import {FeedResponse} from "./FeedService/source";
import {PostEntity} from "../../post/definitions/entity/Post";

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

    getCollectionFeed(collectionId: number, request: FeedRequest): Observable<FeedResponse> {
        let url = `/backend/api/feed/get/collection/${collectionId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }
}