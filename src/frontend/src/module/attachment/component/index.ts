import {Component, Input, Injectable} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-attachment'})

@Injectable()
export class RootAttachment
{
    @Input('attachments') AttachmentInterface;
}