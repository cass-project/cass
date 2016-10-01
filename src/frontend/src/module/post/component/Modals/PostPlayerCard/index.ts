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
    private helper: PostCardHelper;
    private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    @Input('post') post: PostEntity;

    constructor(
        private session: Session
    ) {}

    ngOnChanges() {
        this.helper = new PostCardHelper(
            this.post,
            ViewOptionValue.Feed,
            this.session,
            this.openPostEvent,
            this.openAttachmentEvent
        );
    }
}