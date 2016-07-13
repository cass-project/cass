import {Injectable} from "angular2/core";
import {Http, URLSearchParams, Headers, Response} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Rx";
import {SendProfileMessageRequest} from "../definitions/paths/send";

@Injectable()
export class ProfileIMRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getUnreadMessages() : Observable<Response>
    {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.get(`/backend/api/protected/profile-im/unread`, {headers: authHeader}));
    }
    
    getMessageFrom(sourceProfileId: number, offset: number, limit: number, markAsRead: boolean) : Observable<Response>
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

    sendMessageTo(targetProfileId: number, body:SendProfileMessageRequest) : Observable<Response>
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