import {Injectable} from "@angular/core";
import {Http, URLSearchParams, Headers} from "@angular/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Observable";
import {UploadPostAttachmentResponse200} from "../definitions/paths/upload";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";
import {LinkPostAttachmentResponse200} from "../definitions/paths/link";


@Injectable()
export class PostAttachmentRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    public link(url: string): Observable<LinkPostAttachmentResponse200> {
        let params = new URLSearchParams();
        params.set('url', url);

        let headers = new Headers();

        if(this.token.hasToken()){
            headers.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put('/backend/api/protected/post-attachment/link/', '', {
            search: params,
            headers: headers
        }));
    }
    
    public upload(file: Blob): Observable<UploadPostAttachmentResponse200> {
        let observable = new Observable((observer) => {
            let url = '/backend/api/protected/post-attachment/upload/';
            let xhr = new XMLHttpRequest();

            let formData = new FormData();
            formData.append("file", file);

            xhr.open("POST", url);
            xhr.setRequestHeader('Authorization', this.token.getAPIKey());
            xhr.send(formData);

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    try {
                        let response = JSON.parse(xhr.responseText);

                        if(xhr.status === 200) {
                            observer.next(response);
                            observer.complete();
                        }else{
                            observer.error(response.error);
                        }
                    }catch(error) {
                        observer.error({
                            success: false,
                            error: 'Failed to parse JSON'
                        });
                    }
                }
            }
        });

        let fork = observable.publish().refCount();

        fork.subscribe(
            (success) => {},
            (error) => {
                if((typeof error === 'object') && (typeof error.error === "string")) {
                    this.messages.push(MessageBusNotificationsLevel.Warning, error.error)
                }else if(typeof error == "string") {
                    this.messages.push(MessageBusNotificationsLevel.Warning, error)
                }else{
                    this.messages.push(MessageBusNotificationsLevel.Critical, 'Неизвестная ошибка. Проверьте ваше подключение к Интернету.')
                }
            }
        );

        return <any>fork;
    }
}
