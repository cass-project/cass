import {Component, ViewChild, ElementRef} from "angular2/core";

import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {PostEntity} from "../../../../post/definitions/entity/Post";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";

@Component({
    selector: 'cass-feed-post-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        PostCard,
        LoadingIndicator,
        FeedScrollDetector
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