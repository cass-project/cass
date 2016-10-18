import {EventEmitter} from "@angular/core";

import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {PostEntity} from "../../../definitions/entity/Post";
import {Session} from "../../../../session/Session";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";

export class PostCardHelper
{
    constructor(
        public post: PostEntity,
        public viewMode: ViewOptionValue,
        public session: Session,
        private openPostEvent: EventEmitter<PostEntity>,
        private openAttachmentEvent: EventEmitter<AttachmentEntity<any>>
    ) {}

    private dateCreatedOn: Date;

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    isOwnPost(): boolean {
        if(this.session.isSignedIn()) {
            return this.post.profile_id === this.session.getCurrentProfile().getId();
        }else{
            return false;
        }
    }

    getProfile(): ProfileEntity {
        return this.post.profile;
    }

    getPostDateCreatedOn(): Date {
        if(! this.dateCreatedOn) {
            this.dateCreatedOn = new Date(this.post.date_created_on);
        }

        return this.dateCreatedOn;
    }

    hasTitle(): boolean {
        let hasPostTitle = this.post.title.has && this.post.title.value.length > 0;
        let hasAttachmentTitle = (this.post.attachments.length > 0)
            && (typeof this.post.attachments[0].title === "string")
            && (this.post.attachments[0].title.length > 0);

        return hasPostTitle || hasAttachmentTitle;
    }

    getTitle(): string {
        let hasPostTitle = this.post.title.has && this.post.title.value.length > 0;
        let hasAttachmentTitle = (this.post.attachments.length > 0)
            && (typeof this.post.attachments[0].title === "string")
            && (this.post.attachments[0].title.length > 0);

        if(hasPostTitle) {
            return this.post.title.value;
        }else if(hasAttachmentTitle) {
            return this.post.attachments[0].title;
        }else{
            return '';
        }
    }

    getContent(): string {
        return this.post.content;
    }

    hasContent(): boolean {
        return this.post.content && this.post.content.length > 0;
    }

    hasAttachment(): boolean {
        return this.post.attachments.length > 0;
    }

    getAttachment() {
        return this.post.attachments[0];
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        return this.openAttachmentEvent.emit(attachment);
    }
}