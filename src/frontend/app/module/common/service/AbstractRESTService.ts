import {Injectable} from "angular2/core"
import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export abstract class AbstractRESTService
{
    constructor(protected  http: Http, protected messages: MessageBusService) {}

    handle(request: Observable<Response>): Observable<Response> {
        request.map(res => res.json())
            .subscribe(
                success => {},
                error => {
                    console.log(error);
                }
        );

        return request;
    }
}