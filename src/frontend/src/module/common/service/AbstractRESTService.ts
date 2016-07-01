import {Injectable} from "angular2/core"
import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {MessageBusService} from "../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";
import {AuthService} from "../../auth/service/AuthService";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export abstract class AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) {}

    handle(request: Observable<Response>) {
        let fork = request.publish().refCount();

        fork.catch(error => {
            let response = {
                success: false,
                status: 500,
                error: 'Unknown error'
            };

            if (typeof error === "string") {
                this.genericError(error);
            } else if (typeof error === null) {
                this.unknownError();
            } else if (typeof error === "object") {
                if (error instanceof Response) {
                    try {
                        let parsed = error.json();

                        this.httpError(parsed.error);

                        response.error = parsed.error;
                        response.status = error.status;
                    } catch (error) {
                        this.jsonParseError();
                    }
                } else {
                    this.unknownError();
                }
            } else {
                this.unknownError();
            }

            return Observable.throw(response);
        }).subscribe(
            response => {
                try {
                    response.json();
                } catch (error) {
                    this.jsonParseError();
                }
            },
            error => {}
        );

        return fork;
    }

    private unknownError() {
        this.messages.push(MessageBusNotificationsLevel.Critical, 'Неизвестная ошибка. Проверьте ваше подключение к Интернету.')
    }

    private genericError(error: string) {
        this.messages.push(MessageBusNotificationsLevel.Critical, error);
    }

    private jsonParseError() {
        this.messages.push(MessageBusNotificationsLevel.Critical, 'Не удалось понять, что пришло от нашего сервера. Видимо, разработчики что-то сломали :/');
    }

    private httpError(error: string) {
        this.messages.push(MessageBusNotificationsLevel.Warning, error);
    }
}