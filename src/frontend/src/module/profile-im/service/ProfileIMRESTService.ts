import {Injectable} from "angular2/core";
import {Http, URLSearchParams, Headers} from "angular2/http"
import {Observable} from "rxjs/Rx";

import {SendProfileMessageResponse200, SendProfileMessageRequest} from "../definitions/paths/send";
import {ProfileMessagesResponse200, MessagesSourceType, ProfileMessagesRequest} from "../definitions/paths/messages";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {AuthToken} from "../../auth/service/AuthToken";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService";

@Injectable()
export class ProfileIMRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getUnreadMessages() : Observable<UnreadProfileMessagesResponse200>
    {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.get(`/backend/api/protected/profile-im/unread`, {headers: authHeader}));
    }
    
    getMessageFrom(sourceProfileId: number, offset: number, limit: number, markAsRead: boolean) : Observable<ProfileMessagesResponse200>
    {
        let authHeader = new Headers();
        let params: URLSearchParams = new URLSearchParams();

        params.set('markAsRead', markAsRead.toString());
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        return this.handle(this.http.get(`/backend/api/protected/profile-im/messages/from/${sourceProfileId}/offset/${offset}/limit/${limit}`, {
            search: params,
            headers: authHeader
        }));
    }

    getMessages(targetProfileId:number, source:MessagesSourceType, sourceId:number, body:ProfileMessagesRequest)
    {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        return this.handle(this.http.post(
            `backend/api/protected/with-profile/${targetProfileId}/im/messages/${source}/${sourceId}`, JSON.stringify(body), {headers: authHeader}
        ));
    }
    
    sendMessageTo(targetProfileId: number, body:SendProfileMessageRequest) : Observable<SendProfileMessageResponse200>
    {
        
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.put(
            `/backend/api/protected/profile-im/send/to/${targetProfileId}`, JSON.stringify(body), {headers: authHeader}
        ));
    }
}

