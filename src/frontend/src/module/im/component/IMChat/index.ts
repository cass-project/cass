import {Component, Input} from "@angular/core";
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


    getDate(date): string {
        return (`${date.toLocaleDateString()} at ${date.getHours()}:${date.getMinutes()}`);
    }
}
