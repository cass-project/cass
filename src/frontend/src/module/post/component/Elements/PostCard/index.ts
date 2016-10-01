import {Component, Input, Output, EventEmitter} from "@angular/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {PostCardFeed} from "./view-modes/PostCardFeed/index";
import {PostCardGrid} from "./view-modes/PostCardGrid/index";
import {PostCardList} from "./view-modes/PostCardList/index";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";

@Component({
    selector: 'cass-post-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostCard
{
    @Input('post') post: PostEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

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

export const POST_CARD_DIRECTIVES = [
    PostCard,
    PostCardFeed,
    PostCardGrid,
    PostCardList,
];