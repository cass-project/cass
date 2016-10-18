import {Component, EventEmitter, Output, OnChanges, Input} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";

@Component({
    selector: 'cass-post-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostCardFeed implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    constructor(
        private session: Session
    ) {}

    private helper: PostCardHelper;
    private viewMode: ViewOptionValue = ViewOptionValue.Feed;
    
    ngOnChanges() {
        this.helper = new PostCardHelper(
            this.post,
            this.viewMode,
            this.session,
            this.openPostEvent,
            this.openAttachmentEvent
        );
    }
}