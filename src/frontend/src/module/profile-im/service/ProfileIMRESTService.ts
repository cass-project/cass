import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"
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

    getUnread(targetProfileId:number) : Observable<UnreadProfileMessagesResponse200>
    {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.get(`/backend/api/protected/with-profile/${targetProfileId}/im/unread`, {headers: authHeader}));
    }

    read(
        targetProfileId:number,
        source:MessagesSourceType,
        sourceId:number,
        body:ProfileMessagesRequest
    ) : Observable<ProfileMessagesResponse200>
    {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        return this.handle(this.http.post(
            `backend/api/protected/with-profile/${targetProfileId}/im/messages/${source}/${sourceId}`, JSON.stringify(body), {headers: authHeader}
        ));
    }
    
    send(
        sourceProfileId:number,
        source: MessagesSourceType,
        targetProfileId: number,
        body:SendProfileMessageRequest
    ) : Observable<SendProfileMessageResponse200>
    {
        
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.put(
            `/backend/api/protected/with-profile/${sourceProfileId}/im/send/to/${source}/${targetProfileId}`,
            JSON.stringify(body), {headers: authHeader}
        ));
    }
}

