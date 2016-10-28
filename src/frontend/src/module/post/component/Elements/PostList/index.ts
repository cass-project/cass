import {Component, Input, Output, EventEmitter} from "@angular/core";

import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";
import {PostEntity} from "../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {PostListList} from "./view-modes/PostListList/index";
import {PostListGrid} from "./view-modes/PostListGrid/index";
import {PostListFeed} from "./view-modes/PostListFeed/index";

@Component({
    selector: 'cass-post-list',
    template: require('./template.jade'),
    styles: [
        require('./template.jade')
    ]
})
export class PostList
{
    @Input('posts') posts: PostEntity[] = [];
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open-post') openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') openAttachmentEvent: EventEmitter<PostListOpenAttachmentEvent> = new EventEmitter<PostListOpenAttachmentEvent>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    editPost(post: PostEntity){
        this.editPostEvent.emit(post);
    }

    deletePost(post: PostEntity){
        this.deletePostEvent.emit(post)
    }

    pinPost(post: PostEntity){
        this.pinPostEvent.emit(post)
    }
    
    openAttachment(attachment: AttachmentEntity<any>) {
        let post: PostEntity;

        for(let compare of this.posts) {
            if(compare.attachments && compare.attachments.length) {
                if(compare.attachments[0].id === attachment.id) {
                    post = compare;
                }
            }
        }

        this.openAttachmentEvent.emit({
            post: post,
            attachment: attachment
        });
    }
}

export interface PostListOpenAttachmentEvent
{
    post: PostEntity;
    attachment: AttachmentEntity<any>;
}

export const POST_LIST_DIRECTIVES = [
    PostList,
    PostListFeed,
    PostListGrid,
    PostListList,
];