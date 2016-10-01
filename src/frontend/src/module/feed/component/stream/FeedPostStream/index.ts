import {Component, OnDestroy, OnInit} from "@angular/core";
import {Subscription} from "rxjs";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {PostIndexedEntity, PostEntity} from "../../../../post/definitions/entity/Post";
import {ContentPlayerService} from "../../../../player/service/ContentPlayerService/service";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";
import {PostPlayerService} from "../../../../post/component/Modals/PostPlayer/service";
import {PostListOpenAttachmentEvent} from "../../../../post/component/Elements/PostList/index";

@Component({
    selector: 'cass-feed-post-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedPostStream implements OnDestroy, OnInit
{
    private subscription: Subscription;

    constructor(
        private feed: FeedService<PostIndexedEntity>,
        private contentPlayer: ContentPlayerService,
        private postPlayer: PostPlayerService,
        private options: FeedOptionsService
    ) {}

    ngOnInit() {
        this.subscription = this.feed.observable.subscribe(entities => {
            entities.forEach(entity => {
                if(entity.attachments && entity.attachments.length > 0) {
                    for(let attachment of entity.attachments) {
                        if(this.contentPlayer.isSupported(attachment)) {
                            this.contentPlayer.playlist.push(attachment);
                        }
                    }
                }
            });
        })
    }

    ngOnDestroy() {
        if(! this.contentPlayer.shouldBeVisible()) {
            this.contentPlayer.playlist.empty();
        }

        this.subscription.unsubscribe();
    }
    
    getViewOption() {
        return this.options.view.current;
    }

    isContentPlayerEnabled(): boolean {
        return this.contentPlayer.isEnabled();
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }

    openPost(post: PostEntity) {
        this.postPlayer.openPost(post);
    }

    openAttachment(event: PostListOpenAttachmentEvent) {
        if(this.contentPlayer.isEnabled() && this.contentPlayer.isSupported(event.attachment)) {
            this.contentPlayer.open(event.attachment);

            return false;
        }else{
            this.postPlayer.openPost(event.post);

            return false;
        }
    }
}