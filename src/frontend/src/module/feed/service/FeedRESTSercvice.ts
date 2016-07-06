import {Injectable} from "angular2/core";
import {Http, Headers} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class FeedRESTSercvice extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) {super(http, token, messages)}

    getFeed(collectionId: number, criteria)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }
        
        return this.handle(this.http.post(`/backend/api/feed/collection/${collectionId}`, JSON.stringify({
            criteria: {
                seek: {
                    limit: criteria.seek.limit,
                    offset: criteria.seek.offset
                }
            }
        }), {headers: authHeader}));
    }
}