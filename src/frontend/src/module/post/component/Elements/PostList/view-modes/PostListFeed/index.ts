import {Component, Input, Output, EventEmitter} from "@angular/core";

import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";

@Component({
    selector: 'cass-post-list-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PostListFeed
{
    @Input('posts') posts: PostEntity[] = [];
    @Output('open-post') openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    
    editPost(post: PostEntity){
        this.editPostEvent.emit(post);
    }
    
    deletePost(post: PostEntity){
        this.deletePostEvent.emit(post)
    }
    
    pinPost(post: PostEntity){
        this.pinPostEvent.emit(post)
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        this.openAttachmentEvent.emit(attachment);
    }
}