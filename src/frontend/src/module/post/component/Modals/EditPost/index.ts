import {Component, Input, Output, EventEmitter} from "@angular/core";
import {PostEntity} from "../../../definitions/entity/Post";


@Component({
    selector: 'cass-edit-post',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class EditPost
{
    @Input('post') post: PostEntity;
    @Output('close') close: EventEmitter<boolean> = new EventEmitter<boolean>();


    getAttachmentURL(): string{
        return this.post.attachments[0].link.url;
    }

    closeModal(){
        this.close.emit(true);
    }

}
