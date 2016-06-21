import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {MessageBus} from "angular2/src/web_workers/shared/message_bus";

export abstract class AbstractRESTService
{
    constructor(protected http: Http, private messages: MessageBus) {}

    handle(request: Observable<Response>): Observable<Response> {
        request.map(res => res.json())
            .subscribe(
                success => {},
                error => {
                }
        );

        return request;
    }
}