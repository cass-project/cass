import {Injectable} from "angular2/core";
import {Http, URLSearchParams} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class ProfileIMRESTService extends AbstractRESTService {
    constructor(protected  http:Http, protected messages:MessageBusService) {
        super(http, messages);
    }

    getUnreadMessages(){
        return this.handle(this.http.get(`/backend/api/protected/profile-im/unread`));
    }

    getMessageFrom(sourceProfileId: number, offset: number, limit: number, markAsRead: boolean)
    {
        let params: URLSearchParams = new URLSearchParams();
        params.set('markAsRead', markAsRead.toString());

        return this.handle(this.http.get(`/backend/api/protected/profile-im/messages/from/${sourceProfileId}/offset/${offset}/limit/${limit}`, {
            search: params
        }));
    }

    sendMessageTo(targetProfileId: number, content: string)
    {
        return this.handle(this.http.put(`/backend/api/protected/profile-im/send/to/${targetProfileId}`, JSON.stringify({
            content: content
        })));
    }
}