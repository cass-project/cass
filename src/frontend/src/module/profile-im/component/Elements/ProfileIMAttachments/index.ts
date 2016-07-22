import {Component, Input} from "angular2/core";


@Component({
    selector: 'cass-profile-im-attachments',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
    ]
})

export class ProfileIMAttachments
{
    @Input('disabled') disabled:boolean;
}
