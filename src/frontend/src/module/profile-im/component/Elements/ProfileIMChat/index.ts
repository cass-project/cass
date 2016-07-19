import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams, ROUTER_DIRECTIVES} from "angular2/router";

import {ProfileIMService} from "../../../service/ProfileIMService";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";
import {ProfileIMAttachments} from "../ProfileIMAttachments/index";
import {AuthService} from "../../../../auth/service/AuthService";
import {IMChat} from "../../../../im/component/IMChat/index";
import {IMTextarea} from "../../../../im/component/IMTextarea/index";
import {IMMessagesBodyRequest} from "../../../../im/definitions/paths/im-messages";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProfileIMAttachments,
        IMChat,
        IMTextarea,
        LoadingLinearIndicator
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;
    isNeedScroll = false;
    isLoading = true;
    listerInterval = 5000/*ms*/;
    constructor(private params: RouteParams, private im:ProfileIMService, private authService:AuthService) {
        let profileId = authService.getCurrentAccount().getCurrentProfile().getId();

        this.listen(profileId);
        
        im.createStream("profile", parseInt(params.get('id')))
            .subscribe(() => this.isNeedScroll = true);
    }
    
    ngAfterViewChecked() {
        if(this.isNeedScroll) this.scroll();
    }
    
    scroll() {
        this.isNeedScroll = false;
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }
    
    listen(profileId:number) {
        let loadHistoryBody:IMMessagesBodyRequest = {criteria: {seek: {
            limit: 100
        }}};
        
        let history = this.im.getHistory(parseInt(this.params.get('id')));

        if(history.length > 0) {
            history = history.filter(message => {
                return message.id!==undefined
            });
            loadHistoryBody.criteria.cursor = {id: history[history.length-1].id}
        }
        
        this.im.read(
            profileId,
            "profile",
            parseInt(this.params.get('id')),
            loadHistoryBody
        ).subscribe(() => {
               setTimeout(() => {
                   this.listen(profileId);
               }, this.listerInterval);
            
            this.isNeedScroll = true;
            this.isLoading = false;
        });
    }
    
    onSend($event) {
        this.im.stream.next({
            author: this.authService.getCurrentAccount().getCurrentProfile().entity.profile,
            content: $event.content,
            attachments: $event.attachments,
            send_status: {code: "processing"}
        });
    }
}
