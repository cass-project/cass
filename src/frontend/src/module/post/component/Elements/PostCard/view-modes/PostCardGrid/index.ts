import {Component, EventEmitter, Output, OnChanges, Input} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";
import {QueryTarget, queryImage} from "../../../../../../avatar/functions/query";

@Component({
    selector: 'cass-post-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostCardGrid implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();

    constructor(
        private session: Session
    ) {}

    private helper: PostCardHelper;
    private viewMode: ViewOptionValue = ViewOptionValue.Grid;

    ngOnChanges() {
        this.helper = new PostCardHelper(
            this.post,
            this.viewMode,
            this.session,
            this.openPostEvent,
            this.openAttachmentEvent
        );
    }

    getProfileImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.post.profile.image).public_path;
    }

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }
}