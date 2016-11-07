import {Component, Input, Output, EventEmitter, OnChanges} from "@angular/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {PostCardFeed} from "./view-modes/PostCardFeed/index";
import {PostCardGrid} from "./view-modes/PostCardGrid/index";
import {PostCardList} from "./view-modes/PostCardList/index";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";
import {PostCardHelper} from "./helper";
import {EditPost} from "../../Modals/EditPost/index";

@Component({
    selector: 'cass-post-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        PostCardHelper,
    ]
})
export class PostCard implements OnChanges
{
    @Input('post') post: PostEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    constructor(private helper: PostCardHelper) {}

    ngOnChanges() {
        this.helper.setup({
            post: this.post,
            viewMode: ViewOptionValue.Feed,
            openPostEvent: this.openPostEvent,
            openAttachmentEvent: this.openAttachmentEvent,
            editPostEvent: this.editPostEvent,
            deletePostEvent: this.deletePostEvent,
            pinPostEvent: this.pinPostEvent
        });
    }

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        this.openAttachmentEvent.emit(attachment);
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
}

export const POST_CARD_DIRECTIVES = [
    PostCard,
    PostCardFeed,
    PostCardGrid,
    PostCardList,
    EditPost
];