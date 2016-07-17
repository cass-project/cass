import {Injectable} from "angular2/core";
import {Observable, Observer} from "rxjs/Rx";

import {ProfileIMRESTService} from "./ProfileIMRESTService";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {ProfileMessagesResponse200} from "../definitions/paths/messages";
import {SendProfileMessageResponse200} from "../definitions/paths/send";
import {SendProfileMessageRequest} from "../definitions/paths/send";
import {ProfileIMFeedSendStatus} from "../definitions/entity/ProfileMessage";
import {ProfileMessageEntity} from "../definitions/entity/ProfileMessage";
import {ProfileMessageExtendedEntity} from "../definitions/entity/ProfileMessage";

@Injectable()
export class ProfileIMService 
{
    public history: ProfileMessageExtendedEntity[] = [];
    private getMessageFromCache: ProfileMessagesResponse200[] = [];
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
    
    loadHistory (
        sourceProfileId: number,
        offset: number,
        limit: number,
        markAsRead:boolean,
        nocache?:boolean) : Observable<ProfileMessagesResponse200>
    {
        let stringifyArguments = JSON.stringify(arguments);
        this.clearHistory();
        
        return Observable.create((observer: Observer<ProfileMessagesResponse200>) => {
            if(this.getMessageFromCache[stringifyArguments]===undefined || nocache) {
                this.rest.getMessageFrom(sourceProfileId, offset, limit, markAsRead).subscribe(
                    data => {
                        this.setHistory(data.messages);
                        this.getMessageFromCache[stringifyArguments] = data;
                        observer.next(data);
                        observer.complete();
                    },
                    error => {
                        observer.error(error);
                    }
                );
            } else {
                this.setHistory(this.getMessageFromCache[stringifyArguments].messages);
                observer.next(this.getMessageFromCache[stringifyArguments]);
                observer.complete();
            }
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
    
    clearHistory() {
        this.history = [];
    }
    
    setHistory(messages:ProfileMessageEntity[])
    {
        this.clearHistory();
        messages.forEach((message) => {
            let messageExtented:ProfileMessageExtendedEntity = (<any>Object).assign(message, {
                send_status: {
                    status: ProfileIMFeedSendStatus.Complete
                }
            });
            this.history.push(messageExtented);
        });
    }
}
