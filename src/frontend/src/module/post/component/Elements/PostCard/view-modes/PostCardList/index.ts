import {Component, EventEmitter, Output, OnChanges, Input} from "@angular/core";

import {Session} from "../../../../../../session/Session";
import {PostCardHelper} from "../../helper";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {AttachmentEntity} from "../../../../../../attachment/definitions/entity/AttachmentEntity";
import moment = require("moment");
import {queryImage, QueryTarget} from "../../../../../../avatar/functions/query";

@Component({
    selector: 'cass-post-card-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ],
    providers: [
        PostCardHelper,
    ]
})
export class PostCardList implements OnChanges
{
    @Input('post') private post: PostEntity;
    @Output('open-post') private openPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('open-attachment') private openAttachmentEvent: EventEmitter<AttachmentEntity<any>> = new EventEmitter<AttachmentEntity<any>>();
    @Output('edit-post') private editPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('delete-post') private deletePostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();
    @Output('pin-post') private pinPostEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.List;

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

    openPost(post: PostEntity) {
        this.openPostEvent.emit(post);
    }

    getProfileImageURL(): string {
        return queryImage(QueryTarget.Avatar, this.post.profile.image).public_path;
    }

    getProfileGreetings(): string {
        return this.post.profile.greetings.greetings;
    }

    getDateCreatedOn(): string {
        return moment(this.post.date_created_on).format();
    }
}