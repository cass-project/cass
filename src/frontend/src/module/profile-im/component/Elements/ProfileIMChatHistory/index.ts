import {Component, Input} from "angular2/core";
import {ProfileIMMessageModel} from "../ProfileIMChat/model";

@Component({
    selector: 'cass-profile-im-chat-history',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileIMChatHistory
{
    @Input('history') history:ProfileIMMessageModel[];
}
