import {Injectable} from "@angular/core";
import {Http, URLSearchParams} from "@angular/http";
import {Observable} from "rxjs/Observable";

import {UploadAttachmentResponse200} from "../definitions/paths/upload";
import {LinkAttachmentResponse200} from "../definitions/paths/link";
import {RESTService} from "../../common/service/RESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusNotificationsLevel} from "../../message/component/MessageBusNotifications/model";
import {MessageBusService} from "../../message/service/MessageBusService/index";

export interface AttachmentRESTServiceInterface
{
    link(url: string): Observable<LinkAttachmentResponse200>;
    upload(file: Blob): Observable<UploadAttachmentResponse200>;
}

@Injectable()
export class AttachmentRESTService implements AttachmentRESTServiceInterface
{
    constructor(
        private service: RESTService,
        private token: AuthToken,
        private messages: MessageBusService
    ) {}

    link(url: string): Observable<LinkAttachmentResponse200>
    {
        let params = new URLSearchParams();
        params.set('url', url);

        return this.service.put('/backend/api/protected/attachment/link/', {}, {
            search: params,
        });
    }
    
    upload(file: Blob): Observable<UploadAttachmentResponse200>
    {
        let observable = new Observable((observer) => {
            let url = '/backend/api/protected/attachment/upload/';
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
