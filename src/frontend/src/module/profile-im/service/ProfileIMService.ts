import {Injectable} from "angular2/core";
import {Observable, Observer} from "rxjs/Rx";

import {ProfileIMRESTService}             from "./ProfileIMRESTService";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {ProfileMessagesResponse200}       from "../definitions/paths/messages";
import {SendProfileMessageResponse200}    from "../definitions/paths/send";
import {SendProfileMessageRequest}        from "../definitions/paths/send";
import {ProfileIMFeedSendStatus}          from "../definitions/entity/ProfileMessage";
import {ProfileMessageExtendedEntity}     from "../definitions/entity/ProfileMessage";

@Injectable()
export class ProfileIMService 
{
    public history: ProfileMessageExtendedEntity[] = [];
    public stream: Observer<ProfileMessageExtendedEntity>;
    
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
                    data.messages.forEach((message)=>{
                        this.history.push(<ProfileMessageExtendedEntity>{
                            date_created_on: new Date().toString(),
                            source_profile_id: message.source_profile_id,
                            target_profile_id: message.target_profile_id,
                            content: message.content,
                            send_status:{status:ProfileIMFeedSendStatus.Complete}
                        });
                    });
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

    createStream() : Observable<ProfileMessageExtendedEntity>
    {
        let fork = Observable.create((observer: Observer<ProfileMessageExtendedEntity>)  => {
            this.stream = observer;
        }).publish().refCount();
        
        fork.subscribe(message => {
            this.history.push(message);
            this.sendMessageTo(message.target_profile_id, <SendProfileMessageRequest>{content: message.content})
                .subscribe(
                    () => message.send_status.status = ProfileIMFeedSendStatus.Complete,
                    error => {
                        message.send_status.status = ProfileIMFeedSendStatus.Fail;
                        message.send_status.error_text = JSON.parse(error._body).error;
                    }
                );
        });
        
        return fork;
    }
}
