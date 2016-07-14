import {Component, Input} from "angular2/core";
import {DateFormatter} from 'angular2/src/facade/intl';

import {ProfileMessageExtendedEntity} from "../../../definitions/entity/ProfileMessage";

@Component({
    selector: 'cass-profile-im-chat-history',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class ProfileIMChatHistory
{
    @Input('history') history:ProfileMessageExtendedEntity[];

    dateFormat(date:string, format:string) {
        return DateFormatter.format(new Date(date), 'pt', format);
    }
}
