import {Component, Input} from "@angular/core";


@Component({
    selector: 'cass-im-attachments',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class IMAttachments
{
    @Input('disabled') disabled:boolean;
}
