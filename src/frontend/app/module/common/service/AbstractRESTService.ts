import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {MessageBusNotifications} from "../../message/component/MessageBusNotifications/index";

export abstract class AbstractRESTService
{
    constructor(protected http: Http, private messages: MessageBusNotifications) {}

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