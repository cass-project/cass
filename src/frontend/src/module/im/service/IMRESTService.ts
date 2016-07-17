import {Injectable} from "angular2/core";
import {Http, URLSearchParams, Headers, Response} from "angular2/http"
import {Observable} from "rxjs/Rx";

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {IMSendRequest, IMSendResponse200} from "../definitions/paths/im-send";
import {IMMessagesResponse200, IMMessagesRequest} from "../definitions/paths/im-messages";
import {IMUnread} from "../definitions/paths/im-unread";

@Injectable()
export class IMRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    send(sourceProfileId: number, source: string, sourceId: number, request: IMSendRequest): Observable<IMSendResponse200> {
        let url = `/backend/api/protected/with-profile/${sourceProfileId}/im/send/${source}/${sourceId}`;
        let auth = this.getAuthHeaders();

        return this.handle(
            this.http.put(url, JSON.stringify(request), {
                headers: auth
            })
        );
    }

    messages(targetProfileId: number, source: string, sourceId: number, request: IMMessagesRequest): Observable<IMMessagesResponse200<any>> {
        let url = `/backend/api/protected/with-profile/${targetProfileId}/im/messages/${source}/${sourceId}`;
        let auth = this.getAuthHeaders();

        return this.handle(
            this.http.post(url, JSON.stringify(request), {
                headers: auth
            })
        );
    }

    unread(targetProfileId: number): Observable<IMUnread> {
        let url = `/backend/api/protected/with-profile/${targetProfileId}/im/unread`;
        let auth = this.getAuthHeaders();

        return this.handle(
            this.http.get(url, {
                headers: auth
            })
        );
    }
}