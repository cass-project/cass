import {Component, Input, Directive} from "@angular/core";
import {IMMessageExtendedEntity} from "../../definitions/entity/IMMessage";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-im-chat'})

export class IMChat
{
    @Input('messages') messages:IMMessageExtendedEntity[];


    getDate(date): string {
        return (`${date.toLocaleDateString()} at ${date.getHours()}:${date.getMinutes()}`);
    }
}
