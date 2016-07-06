import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class ProfileCommunitiesRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getJoinedCommunities()
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.get(`/backend/api/protected/profile/current/joined-communities`, {headers: authHeader}));
    }

    joinCommunity(communitySID){
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.put(`/backend/api/protected/community/${communitySID}/join`, '', {headers: authHeader}));
    }

    leaveCommunity(communitySID){
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.put(`/backend/api/protected/community/${communitySID}/leave`, '', {headers: authHeader}));
    }
}