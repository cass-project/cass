import {Component, Input} from "angular2/core";
import {DateFormatter} from 'angular2/src/facade/intl';

import {IMMessageExtendedEntity} from "../../definitions/entity/IMMessage";

@Component({
    selector: 'cass-im-chat',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class IMChat
{
    @Input('messages') messages:IMMessageExtendedEntity[];

    dateFormat(date:string, format:string) {
        return DateFormatter.format(new Date(date), 'pt', format);
    }
}
