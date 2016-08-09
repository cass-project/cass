import {Component, ViewChild, ElementRef, EventEmitter} from "@angular/core";
import {ROUTER_DIRECTIVES} from "@angular/router";
import {RouteParams} from "@angular/router-deprecated";

import {ProfileIMService} from "../../../service/ProfileIMService";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";
import {IMChat} from "../../../../im/component/IMChat/index";
import {IMTextarea} from "../../../../im/component/IMTextarea/index";
import {IMMessagesBodyRequest} from "../../../../im/definitions/paths/im-messages";
import {IMAttachments} from "../../../../im/component/IMAttachments/index";
import {Session} from "../../../../session/Session";
import {IMMessageSourceEntityType} from "../../../../im/definitions/entity/IMMessageSource";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        IMAttachments,
        IMChat,
        IMTextarea,
        LoadingLinearIndicator
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;
    private isLoading = true;
    private listerInterval = 5000/*ms*/;
    private scroll = new EventEmitter<boolean>();
    private source:IMMessageSourceEntityType;
    
    constructor(
        private params: RouteParams, 
        private service: ProfileIMService, 
        private session: Session
    ) {
        let profileId = session.getCurrentProfile().getId();

        this.listen(profileId);

        service.createStream("profile", parseInt(params.get('id')))
            .subscribe(() => this.scroll.emit(true));
        
        this.scroll.subscribe(force => {
            let offsetBottom = this.content.nativeElement.scrollHeight - this.content.nativeElement.scrollTop - this.content.nativeElement.clientHeight;
            if(offsetBottom < 300 || force) {
                this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
            }
        })
    }
    
    listen(profileId:number) {
        let loadHistoryBody:IMMessagesBodyRequest = {criteria: {seek: {
            limit: 0
        }}};
        
        let history = this.service.getHistory(parseInt(this.params.get('id')));

        if(history.length > 0) {
            history = history.filter(message => {
                return message.id!==undefined
            });
            loadHistoryBody.criteria.cursor = {id: history[history.length-1].id}
        }
        
        this.service.read(
            profileId,
            "profile",
            parseInt(this.params.get('id')),
            loadHistoryBody
        ).subscribe(data => {
            this.source = data.source.entity;
            
            setTimeout(() => {
               this.listen(profileId);
            }, this.listerInterval);
            
            this.scroll.emit(this.isLoading);
            this.isLoading = false;
        });
    }
    
    onSend($event) {
        this.service.stream.next({
            author: this.session.getCurrentProfile().entity.profile,
            content: $event.content,
            attachments: $event.attachments,
            send_status: {code: "processing"}
        });
    }
}

