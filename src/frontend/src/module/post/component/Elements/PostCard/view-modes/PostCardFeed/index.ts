import {Component, EventEmitter, Output, OnChanges, Input} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";
import {TranslationService} from "../../../../../../i18n/service/TranslationService";

@Component({
    selector: 'cass-post-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})

export class PostCardFeed implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;

    constructor(
        private helper: PostCardHelper,
        private session: Session,
    ) {}

    ngOnChanges() {
        this.helper.setup({
            post: this.post,
            viewMode: this.viewMode,
            openPostEvent: this.openPostEvent,
            openAttachmentEvent: this.openAttachmentEvent,
            editPostEvent: this.editPostEvent,
            deletePostEvent: this.deletePostEvent,
            pinPostEvent: this.pinPostEvent
        });
    }
}