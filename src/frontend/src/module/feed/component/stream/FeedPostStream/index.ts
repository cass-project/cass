import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {PostIndexedEntity, PostEntity} from "../../../../post/definitions/entity/Post";
import {ContentPlayerService} from "../../../../player/service/ContentPlayerService/service";
import {PostPlayerService} from "../../../../post/component/Modals/PostPlayer/service";
import {PostListOpenAttachmentEvent} from "../../../../post/component/Elements/PostList/index";

@Component({
    selector: 'cass-feed-post-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedPostStream
{
    constructor(
        private feed: FeedService<PostIndexedEntity>,
        private contentPlayer: ContentPlayerService,
        private postPlayer: PostPlayerService,
        private options: FeedOptionsService
    ) {}
    
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