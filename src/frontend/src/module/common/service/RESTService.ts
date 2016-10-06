import {Injectable} from "@angular/core";
import {Http, Response, Headers, RequestOptionsArgs} from "@angular/http";
import {Observable} from "rxjs/Observable";

import {MessageBusService} from "../../message/service/MessageBusService/index";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";
import {AuthToken} from "../../auth/service/AuthToken";
import {parseError} from "../functions/parseError";

@Injectable()
export class RESTService
{
    constructor(
        public http: Http,
        public token: AuthToken,
        public messages: MessageBusService
    ) {}

    public get(url: string, options: RequestOptionsArgs = {}) {
        if(this.token.isAvailable()) {
            options['headers'] = this.getAuthHeaders();
        }

        return this.handle(this.http.get(url, options));
    }

    public put(url: string, json: any, options: RequestOptionsArgs = {})
    {
        if(this.token.isAvailable()) {
            options['headers'] = this.getAuthHeaders();
        }

        return this.handle(this.http.put(url, JSON.stringify(json), options));
    }

    public post(url: string, json: any, options: RequestOptionsArgs = {})
    {
        if(this.token.isAvailable()) {
            options['headers'] = this.getAuthHeaders();
        }

        return this.handle(this.http.post(url, JSON.stringify(json), options));
    }

    public delete(url: string, options: RequestOptionsArgs = {})
    {
        if(this.token.isAvailable()) {
            options['headers'] = this.getAuthHeaders();
        }

        return this.handle(this.http.delete(url, options));
    }

    public parseError(error): string {
        return parseError(error);
    }

    public getAuthHeaders(): Headers {
        let authHeader = new Headers();

        if(this.token.isAvailable()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return authHeader;
    }

    public handle(request) {
        let fork = request.publish().refCount();

        fork
            .catch(error => {
                return Observable.onErrorResumeNext(Observable.throw(this.handleError(error)));
            })
            .subscribe(() => {});

        return fork.map(res => res.json());
    }

    private handleError(error)
    {
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
        
        return response;
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