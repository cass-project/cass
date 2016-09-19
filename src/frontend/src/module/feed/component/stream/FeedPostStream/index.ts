import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {PostIndexedEntity} from "../../../../post/definitions/entity/Post";

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
        private options: FeedOptionsService
    ) {}
    
    getViewOption() {
        return this.options.view.current;
    } 

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}