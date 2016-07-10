import {Injectable} from "angular2/core";
import {Http, URLSearchParams} from "angular2/http";

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {Observable} from "rxjs/Observable";
import {GetOpenGraphResponse200} from "../definitions/paths/get-opg";

@Injectable()
export class OpenGraphRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    private getOpenGraph(url: string): Observable<GetOpenGraphResponse200> {
        let params: URLSearchParams = new URLSearchParams();
        params.set('url', url);

        return this.handle(this.http.get('/backend/api/og/get-og', {
            search: params
        }));
    }
}