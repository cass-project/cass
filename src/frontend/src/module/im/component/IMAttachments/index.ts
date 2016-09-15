import {Component, Input} from "@angular/core";


@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-im-attachments'})

export class IMAttachments
{
    @Input('disabled') disabled:boolean;
}
