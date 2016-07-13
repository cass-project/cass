import {Injectable} from "angular2/core";
import {ProfileIMRESTService} from "./ProfileIMRESTService";
import {Observable} from "rxjs/Rx";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {SendProfileMessageResponse200, SendProfileMessageRequest} from "../definitions/paths/send";
import {ProfileIMMessageModel} from "../component/Elements/ProfileIMMessages/model";
import {ProfileMessagesResponse200} from "../definitions/paths/messages";

@Injectable()
export class ProfileIMService 
{
    constructor(private rest:ProfileIMRESTService) {}

    getUnreadMessages() : Observable<UnreadProfileMessagesResponse200> 
    {
        return Observable.create(observer => {
            this.rest.getUnreadMessages().subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }
    
    getMessageFrom(sourceProfileId: number, offset: number, limit: number, markAsRead: boolean) : Observable<ProfileMessagesResponse200>
    {
        return Observable.create(observer => {
            this.rest.getMessageFrom(sourceProfileId, offset, limit, markAsRead).subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }
    sendMessageTo(targetProfileId: number, body:SendProfileMessageRequest) : Observable<SendProfileMessageResponse200>
    {
        return Observable.create(observer => {
            this.rest.sendMessageTo(targetProfileId, body).subscribe(
                data => {
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }
}
