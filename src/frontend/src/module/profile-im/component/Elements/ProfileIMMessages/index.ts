import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams} from "angular2/router";

import {ProfileIMTextarea} from "../ProfileIMTextarea/index";
import {ProfileIMMessagesModel, ProfileIMMessageModel} from "./model";
import {ProfileIMService} from "../../../service/ProfileIMService";
import {AuthService} from "../../../../auth/service/AuthService";
import {SendProfileMessageRequest} from "../../../definitions/paths/send";
import {ProfileCachedIdentityMap} from "../../../../profile/service/ProfileCachedIdentityMap";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileIMTextarea
    ]
})

export class ProfileIMMessages
{
    @ViewChild('chatlog') chatlog:ElementRef;
    private targetProfileId:number;
    constructor(
        private params: RouteParams,
        private imModel:ProfileIMMessagesModel,
        private imService:ProfileIMService,
        private authService:AuthService
    ) {
        this.targetProfileId = parseInt(params.get('id'));
        this.imService.getMessageFrom(this.targetProfileId, 0, 10, false).subscribe(
            data => {
                data.messages.forEach((message)=>{
                    this.imModel.history.push({
                        source_profile: this.authService.getCurrentAccount().getCurrentProfile().entity,
                        target_profile_id: message.target_profile_id,
                        content: message.content,
                        isSended: true,
                        hasError: false,
                    });
                });
            }
        )
    }
    
    send(content:string) {
        if(content!=="") {
            let message:ProfileIMMessageModel = {
                source_profile: this.authService.getCurrentAccount().getCurrentProfile().entity,
                target_profile_id: this.targetProfileId,
                content: content,
                isSended: false,
                hasError: false,
            };
            this.imModel.history.push(message);
            
            setTimeout(() => { // ngFor срабатывает позже расчетов, по этому обернуто в setTimeout 
                let contentWindow = document.getElementById('cassAppContainer').getElementsByClassName('content')[0];
                contentWindow.scrollTop = this.chatlog.nativeElement.scrollHeight;
            }, 0); 
            
            this.imService.sendMessageTo(this.targetProfileId, <SendProfileMessageRequest>{content: content}).subscribe(
                () => {
                    message.isSended = true;
                },
                () => {
                    message.hasError = true;
                }
            );
        }
    }
    
}
