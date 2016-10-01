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
    @Output('open-attachment') openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        this.openAttachmentEvent.emit(attachment);
    }
}

export const POST_LIST_DIRECTIVES = [
    PostList,
    PostListFeed,
    PostListGrid,
    PostListList,
];