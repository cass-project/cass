import {Injectable} from "angular2/core";
import {Observable, Observer} from "rxjs/Rx";

import {ProfileIMRESTService}             from "./ProfileIMRESTService";
import {ProfileIMMessageModel}            from "../component/Elements/ProfileIMChat/model";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {ProfileMessagesResponse200}       from "../definitions/paths/messages";
import {SendProfileMessageResponse200}    from "../definitions/paths/send";
import {SendProfileMessageRequest}        from "../definitions/paths/send";

@Injectable()
export class ProfileIMService 
{
    public stream: Observer<ProfileIMMessageModel>;
    
    constructor(private rest:ProfileIMRESTService) {}

    getUnreadMessages() : Observable<UnreadProfileMessagesResponse200> 
    {
        return Observable.create((observer: Observer<UnreadProfileMessagesResponse200>) => {
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
        return Observable.create((observer: Observer<ProfileMessagesResponse200>) => {
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
        return Observable.create((observer: Observer<SendProfileMessageResponse200>) => {
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

    createStream() : Observable<ProfileIMMessageModel>
    {
        return Observable.create((observer: Observer<ProfileIMMessageModel>)  => {
            this.stream = observer;
        });        
    }
}
