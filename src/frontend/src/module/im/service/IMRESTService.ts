import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {Observable} from "rxjs/Rx";

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {IMSendBodyRequest, IMSendResponse200} from "../definitions/paths/im-send";
import {IMMessagesResponse200, IMMessagesBodyRequest} from "../definitions/paths/im-messages";
import {IMUnread} from "../definitions/paths/im-unread";
import {IMMessageSourceEntityTypeCode, IMMessageSourceEntityType} from "../definitions/entity/IMMessageSource";

@Injectable()
export class IMRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    send(
        sourceProfileId: number,
        source: IMMessageSourceEntityTypeCode,
        sourceId: number,
        body: IMSendBodyRequest
    ): Observable<IMSendResponse200> 
    {
        let url = `/backend/api/protected/with-profile/${sourceProfileId}/im/send/${source}/${sourceId}`;

        return this.handle(
            this.http.put(url, JSON.stringify(body), {
                headers: this.getAuthHeaders()
            })
        );
    }

    read(
        targetProfileId: number, 
        source: IMMessageSourceEntityTypeCode, 
        sourceId: number,
        body: IMMessagesBodyRequest
    ): Observable<IMMessagesResponse200<IMMessageSourceEntityType>>
    {
        let url = `/backend/api/protected/with-profile/${targetProfileId}/im/messages/${source}/${sourceId}`;

        return this.handle(
            this.http.post(url, JSON.stringify(body), {
                headers: this.getAuthHeaders()
            })
        );
    }

    unreadInfo(targetProfileId: number): Observable<IMUnread> {
        let url = `/backend/api/protected/with-profile/${targetProfileId}/im/unread`;
        let auth = this.getAuthHeaders();

        return this.handle(
            this.http.get(url, {
                headers: auth
            })
        );
    }
    
    test(){
        
        this.read(1,"profile",1,{
            "criteria": {
                "seek": {
                },
                "cursor": {
                    "id": "578d64300640fd4f9d58cfa1"
                }
            }
        }).subscribe(
            data=>{
                console.log(data.source.entity.image)
            }
        )
    }
}