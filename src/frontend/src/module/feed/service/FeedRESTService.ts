import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Observable";
import {GetProfileFeedSuccess200} from "../definitions/paths/get-profile";
import {FeedRequest} from "../definitions/request/FeedRequest";
import {GetCollectionSuccess200} from "../definitions/paths/get-collection";

@Injectable()
export class FeedRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getProfileFeed(profileId: number, request: FeedRequest): Observable<GetProfileFeedSuccess200> {
        let url = `/backend/api/feed/get/profile/${profileId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    getCollectionFeed(collectionId: number, request: FeedRequest): Observable<GetCollectionSuccess200> {
        let url = `/backend/api/feed/get/collection/${collectionId}`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }
}