import {Component, Input, Output, EventEmitter} from "@angular/core";

import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";

@Component({
    selector: 'cass-post-list-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PostListList
{
    @Input('posts') posts: PostEntity[] = [];
    @Output('open-post') openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    private viewMode: ViewOptionValue = ViewOptionValue.List;

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        this.openAttachmentEvent.emit(attachment);
    }
}