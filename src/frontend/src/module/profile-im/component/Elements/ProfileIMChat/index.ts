import {Component, OnInit, ViewChild, ElementRef, EventEmitter, Directive} from "@angular/core";
import {ActivatedRoute} from '@angular/router';

import {ProfileIMService} from "../../../service/ProfileIMService";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";
import {IMChat} from "../../../../im/component/IMChat/index";
import {IMTextarea} from "../../../../im/component/IMTextarea/index";
import {IMMessagesBodyRequest} from "../../../../im/definitions/paths/im-messages";
import {IMAttachments} from "../../../../im/component/IMAttachments/index";
import {Session} from "../../../../session/Session";
import {IMMessageSourceEntityType} from "../../../../im/definitions/entity/IMMessageSource";
import {Observable} from "rxjs/Observable";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-profile-im-messages'})

export class ProfileIMChat implements OnInit
{
    @ViewChild('content') content:ElementRef;
    private isLoading = true;
    private listerInterval = 5000/*ms*/;
    private scroll = new EventEmitter<boolean>();
    private source:IMMessageSourceEntityType;
    private sidChat: number;
    
    constructor(
        private route: ActivatedRoute,
        private service: ProfileIMService, 
        private session: Session
    ) {}

    ngOnInit(){
        let profileId = this.session.getCurrentProfile().getId();

        this.listen(profileId);

        this.route.params.map(params => {
            this.sidChat = parseInt(params['id']);
        });

        this.service.createStream("profile", this.sidChat)
            .subscribe(() => this.scroll.emit(true));

        this.scroll.subscribe(force => {
            let offsetBottom = this.content.nativeElement.scrollHeight - this.content.nativeElement.scrollTop - this.content.nativeElement.clientHeight;
            if(offsetBottom < 300 || force) {
                this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
            }
        })}
    
    listen(profileId:number) {
        let loadHistoryBody:IMMessagesBodyRequest = {criteria: {seek: {
            limit: 0
        }}};
        
        let history = this.service.getHistory(this.sidChat);

        if(history.length > 0) {
            history = history.filter(message => {
                return message.id!==undefined
            });
            loadHistoryBody.criteria.cursor = {id: history[history.length-1].id}
        }
        
        this.service.read(
            profileId,
            "profile",
            this.sidChat,
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

