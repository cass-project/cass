import {Injectable} from "angular2/core";
import {Http, Response, Headers} from "angular2/http";
import {Observable} from "rxjs/Rx";

import {FeedbackCreateRequest} from "../definitions/paths/create";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class FeedbackRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {super(http, token, messages)}
    
    public create(request: FeedbackCreateRequest) : Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put("/backend/api/feedback/create", JSON.stringify(request), {headers: authHeader}));
    }
}
