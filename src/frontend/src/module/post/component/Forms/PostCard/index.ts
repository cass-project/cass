import {Component, Input, Output, EventEmitter} from "@angular/core";

import {PostEntity} from "../../../definitions/entity/Post";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {Session} from "../../../../session/Session";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {PostCardFeed} from "./view-modes/PostCardFeed/index";
import {PostCardGrid} from "./view-modes/PostCardGrid/index";
import {PostCardListItem} from "./view-modes/PostCardListItem/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-post-card'})

export class PostCard
{
    @Input('post') post: PostEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Input('content-player-enabled') contentPlayerEnabled: boolean = false;
    @Output('open') openEvent: EventEmitter<PostEntity> = new EventEmitter<PostEntity>();

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

    open() {
        this.openEvent.emit(this.post);
    }
}

export const POST_CARD_DIRECTIVES = [
    PostCard,
    PostCardFeed,
    PostCardGrid,
    PostCardListItem,
];