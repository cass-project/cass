import {Injectable} from "@angular/core";
import {Observable, Observer} from "rxjs/Rx";
import {IMMessageExtendedEntity, IMMessageEntity} from "../../im/definitions/entity/IMMessage";
import {IMUnreadResponse200} from "../../im/definitions/paths/im-unread";
import {IMRESTService} from "../../im/service/IMRESTService";
import {IMMessageSourceEntityTypeCode} from "../../im/definitions/entity/IMMessageSource";
import {IMMessagesBodyRequest, IMMessagesResponse200} from "../../im/definitions/paths/im-messages";
import {IMSendBodyRequest, IMSendResponse200} from "../../im/definitions/paths/im-send";

@Injectable()
export class ProfileIMService 
{
    public history: {[key: string]: IMMessageExtendedEntity[]} = <any>[];
    public stream: Observer<IMMessageExtendedEntity>;
    
    constructor(private rest:IMRESTService) {}

    send(
        sourceProfileId:number,
        source: IMMessageSourceEntityTypeCode,
        sourceId: number,
        body:IMSendBodyRequest
    ) : Observable<IMSendResponse200>
    {
        return Observable.create((observer: Observer<IMSendResponse200>) => {
            this.rest.send(sourceProfileId, source, sourceId, body).subscribe(
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
        source:IMMessageSourceEntityTypeCode,
        sourceId:number,
        body:IMMessagesBodyRequest
    ): Observable<IMMessagesResponse200>
    {
        return Observable.create((observer: Observer<IMMessagesResponse200>) => {
            this.rest.read(targetProfileId, source, sourceId, body).subscribe(
                data => {
                    this.setHistory(data.source.entity.id, data.messages);
                    observer.next(data);
                    observer.complete();
                },
                error => {
                    observer.error(error);
                }
            );
        });
    }

    unreadInfo(targetProfileId:number) : Observable<IMUnreadResponse200>
    {
        return Observable.create((observer: Observer<IMUnreadResponse200>) => {
            this.rest.unreadInfo(targetProfileId).subscribe(
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

    createStream(source: IMMessageSourceEntityTypeCode, targetProfileId:number) : Observable<IMMessageExtendedEntity>
    {
        let fork = Observable.create((observer: Observer<IMMessageExtendedEntity>)  => {
            this.stream = observer;
        }).publish().refCount();
        
        fork.subscribe(message => {
            this.push(targetProfileId, message);
            this.send(
                message.author.id,
                source,
                targetProfileId,
                {
                    message: message.content,
                    attachment_ids: message.attachments
                }
            ).subscribe(
                data => {
                    message.id = data.message.id;
                    message.date_created = data.message.date_created;
                    message.send_status.code = "complete";
                },
                error => {
                    message.send_status.code = "fail";
                    message.send_status.error_text = JSON.parse(error._body).error;
                }
            );
        });
        
        return fork;
    }
    
    clearHistory(sourceId:number) 
    {
        this.history[sourceId] = [];
    }
    
    setHistory(sourceId:number, messages:IMMessageEntity[])
    {
        messages.forEach(
            message => this.push(sourceId, (<any>Object).assign(message, {
                send_status: {
                    code: "complete"
                }
            }))
        );
    }
    
    getHistory(sourceId:number) : IMMessageExtendedEntity[] 
    {
        return this.history[sourceId] || [];
    }
    
    push(sourceId:number, message:IMMessageExtendedEntity) 
    {
        if(!this.history[sourceId]) {
            this.history[sourceId] = [];
        }
        this.history[sourceId].push(message);
    }
}
