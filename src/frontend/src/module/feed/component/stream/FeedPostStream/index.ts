import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {PostIndexedEntity, PostEntity} from "../../../../post/definitions/entity/Post";
import {ContentPlayerService} from "../../../../player/service/ContentPlayerService";
import {AttachmentEntity} from "../../../../attachment/definitions/entity/AttachmentEntity";

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
        console.log('open post', post);
    }

    openAttachment(attachment: AttachmentEntity<any>) {
        console.log('open attachment', attachment);
    }
}