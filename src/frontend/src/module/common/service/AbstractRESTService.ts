import {Injectable} from "angular2/core"
import {Http, Response} from "angular2/http";
import {Observable} from "rxjs/Observable";

import {MessageBusService} from "../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export abstract class AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) {}
    
    public parseError(error): string {
        if(typeof error === "object") {
            if(error.error && typeof error.error === 'string') {
                return error.error;
            }else{
                return 'Unknown error';
            }
        }else{
            return 'Failed to parse JSON';
        }
    }

    handle(request) {
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
        });

        return fork.map(res => res.json());
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