import {Component} from "angular2/core";

import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {PostEntity} from "../../../../post/definitions/entity/Post";
import {FeedOptionsService} from "../../../service/FeedOptionsService";

@Component({
    selector: 'cass-feed-post-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostCard,
        LoadingIndicator,
    ]
})
export class FeedPostStream
{
    constructor(
        private feed: FeedService<PostEntity>,
        private options: FeedOptionsService
    ) {}
    
    getViewOption() {
        return this.options.view.current;
    } 

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}