import {Component, Input, Output, EventEmitter, Injectable, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-post-attachment'})

@Injectable()
export class PostAttachment
{
    @Input('attachments') AttachmentInterface;
}