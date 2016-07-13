import {Component, ViewChild, ElementRef} from "angular2/core";
import {RouteParams} from "angular2/router";

import {AuthService}               from "../../../../auth/service/AuthService";
import {SendProfileMessageRequest} from "../../../definitions/paths/send";
import {ProfileIMService}          from "../../../service/ProfileIMService";
import {ProfileIMChatHistory}      from "../ProfileIMChatHistory/index";
import {ProfileIMTextarea}         from "../ProfileIMTextarea/index";
import {ProfileIMMessagesModel}    from "./model";

@Component({
    selector: 'cass-profile-im-messages',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileIMTextarea,
        ProfileIMChatHistory
    ]
})

export class ProfileIMChat
{
    @ViewChild('content') content:ElementRef;

    constructor(
        private params: RouteParams,
        private imModel:ProfileIMMessagesModel,
        private imService:ProfileIMService,
        private authService:AuthService
    ) {
        imService.getMessageFrom(parseInt(params.get('id')), 0, 10, false).subscribe(
            data => {
                data.messages.forEach((message)=>{
                    imModel.history.push({
                        source_profile: this.authService.getCurrentAccount().getCurrentProfile().entity,
                        target_profile_id: message.target_profile_id,
                        content: message.content,
                        is_sended: true,
                        has_error: false,
                    });
                    setTimeout(() => this.scroll(), 0); // ngFor срабатывает позже расчетов, по этому обернуто в setTimeout
                });
            }
        );

        imService.createStream().subscribe(message => {
            imModel.history.push(message);
            setTimeout(() => this.scroll(), 0); // ngFor срабатывает позже расчетов, по этому обернуто в setTimeout
            imService.sendMessageTo(message.target_profile_id, <SendProfileMessageRequest>{content: message.content})
                .subscribe(
                    () => message.is_sended = true,
                    () => message.has_error = true
                );
        });
    }

    scroll() {
        this.content.nativeElement.scrollTop = this.content.nativeElement.scrollHeight;
    }
}
