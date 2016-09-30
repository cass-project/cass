import {Component, EventEmitter} from "@angular/core";

import {Input, Output} from "@angular/core/src/metadata/directives";
import {PostEntity} from "../../../../../definitions/entity/Post";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {PostCard} from "../../index";
import {Session} from "../../../../../../session/Session";
import {ProfileEntity} from "../../../../../../profile/definitions/entity/Profile";

@Component({
    selector: 'cass-post-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostCardFeed
{
    @Input('post') post: PostEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Input('content-player-enabled') contentPlayerEnabled: boolean = false;
    @Output('go') goEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

    private dateCreatedOn: Date;

    constructor(
        protected session: Session
    ) {}

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    isOwnPost(): boolean{
        if(this.session.isSignedIn()) {
            return this.post.profile_id === this.session.getCurrentProfile().getId();
        }else{
            return false;
        }
    }

    getProfile(): ProfileEntity
    {
        return this.post.profile;
    }

    getPostDateCreatedOn(): Date
    {
        if(! this.dateCreatedOn) {
            this.dateCreatedOn = new Date(this.post.date_created_on);
        }

        return this.dateCreatedOn;
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

    go() {
        this.goEvent.emit(this.post);
    }
}