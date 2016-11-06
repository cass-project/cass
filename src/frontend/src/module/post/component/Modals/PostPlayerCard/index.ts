import {Component, Input, OnChanges, EventEmitter} from "@angular/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {PostCardHelper} from "../../Elements/PostCard/helper";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";
import {Session} from "../../../../session/Session";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";

@Component({
    selector: 'cass-post-player-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostPlayerCard implements OnChanges
{
    @Input('post') post: PostEntity;

    private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    constructor(
        private session: Session,
        private helper: PostCardHelper,
    ) {}

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
}