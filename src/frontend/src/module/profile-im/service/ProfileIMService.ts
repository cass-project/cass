import {Injectable} from "angular2/core";
import {Observable, Observer} from "rxjs/Rx";

import {ProfileIMRESTService} from "./ProfileIMRESTService";
import {UnreadProfileMessagesResponse200} from "../definitions/paths/unread";
import {ProfileMessagesResponse200, MessagesSourceType, ProfileMessagesRequest} from "../definitions/paths/messages";
import {SendProfileMessageResponse200} from "../definitions/paths/send";
import {SendProfileMessageRequest} from "../definitions/paths/send";
import {ProfileIMFeedSendStatus} from "../definitions/entity/ProfileMessage";
import {ProfileMessageEntity} from "../definitions/entity/ProfileMessage";
import {ProfileMessageExtendedEntity} from "../definitions/entity/ProfileMessage";

@Injectable()
export class ProfileIMService 
{
    public history: {[key: string]: ProfileMessageExtendedEntity[]} = <any>[];
    public stream: Observer<ProfileMessageExtendedEntity>;
    
    constructor(private rest:ProfileIMRESTService) {}

    getUnread(targetProfileId:number) : Observable<UnreadProfileMessagesResponse200> 
    {
        return Observable.create((observer: Observer<UnreadProfileMessagesResponse200>) => {
            this.rest.getUnread(targetProfileId).subscribe(
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

    read(
        targetProfileId:number,
        source:MessagesSourceType,
        sourceId:number, 
        body:ProfileMessagesRequest
    ) : Observable<ProfileMessagesResponse200>
    {
        return Observable.create((observer: Observer<ProfileMessagesResponse200>) => {
            this.rest.read(targetProfileId, source, sourceId, body).subscribe(
                data => {
                    this.setHistory(data.messages);
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }
    
    sendMessageTo(
        sourceProfileId:number,
        source: MessagesSourceType,
        targetProfileId: number,
        body:SendProfileMessageRequest
    ) : Observable<SendProfileMessageResponse200>
    {
        return Observable.create((observer: Observer<SendProfileMessageResponse200>) => {
            this.rest.send(sourceProfileId, source, targetProfileId, body).subscribe(
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

    createStream(source: MessagesSourceType, targetProfileId:number) : Observable<ProfileMessageExtendedEntity>
    {
        let fork = Observable.create((observer: Observer<ProfileMessageExtendedEntity>)  => {
            this.stream = observer;
        }).publish().refCount();
        
        fork.subscribe(message => {
            this.push(targetProfileId, message);
            this.sendMessageTo(
                message.author.id,
                source,
                targetProfileId,
                <SendProfileMessageRequest>{
                    message: message.content,
                    attachment_ids: message.attachments
                }
            )
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
    
    clearHistory(targetProfileId) {
        this.history[targetProfileId] = [];
    }
    
    setHistory(messages:ProfileMessageEntity[])
    {
        messages.forEach(
            message => this.push(message.author.id, (<any>Object).assign(message, {
                send_status: {
                    status: ProfileIMFeedSendStatus.Complete
                }
            }))
        );
    }
    
    getHistory(targetProfileId:number) : ProfileMessageExtendedEntity[] {
        return this.history[targetProfileId] || []; 
    }
    
    push(targetProfileId:number, message:ProfileMessageExtendedEntity) {
        if(!this.history[targetProfileId]) {
            this.history[targetProfileId] = [];
        }
        this.history[targetProfileId].push(message);
    }
}
