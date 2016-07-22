import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams, ROUTER_DIRECTIVES} from "angular2/router";

import {ProfileIMService} from "../../../service/ProfileIMService";
import {ProfileIMChatHistory} from "../ProfileIMChatHistory/index";
import {ProfileIMTextarea} from "../ProfileIMTextarea/index";
import {LoadingLinearIndicator} from "../../../../form/component/LoadingLinearIndicator/index";
import {ProfileIMAttachments} from "../ProfileIMAttachments/index";
import {AuthService} from "../../../../auth/service/AuthService";
import {MessagesSourceType, ProfileMessagesRequest} from "../../../definitions/paths/messages";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        ProfileIMTextarea,
        ProfileIMChatHistory,
        ProfileIMAttachments,
        LoadingLinearIndicator
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;
    isNeedScroll = false;
    isLoading = true;
    listerInterval = 5000/*ms*/;
    constructor(private params: RouteParams, private im:ProfileIMService, authService:AuthService) {
        let profileId = authService.getCurrentAccount().getCurrentProfile().getId();

        this.listen(profileId);
        
        im.createStream(MessagesSourceType.Profile, parseInt(params.get('id')))
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
        let loadHistoryBody:ProfileMessagesRequest = {criteria: {seek: {
            offset: 0,
            limit: 10
        }}};
        
        let history = this.im.getHistory(parseInt(this.params.get('id')));
        console.log(history.length);
        if(history.length>0) {
            loadHistoryBody.criteria.cursor = {id: history[history.length-1].id.toString()}
        }
        
        this.im.read(
            profileId,
            MessagesSourceType.Profile,
            parseInt(this.params.get('id')),
            loadHistoryBody
        ).subscribe(() => {
            setTimeout(()=>{
                this.listen(profileId);
            }, this.listerInterval);
            
            this.isNeedScroll = true;
            this.isLoading = false;
        });
    }
}
