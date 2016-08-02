import {Component} from "angular2/core";

import {PostCard} from "../../../../post/component/Forms/PostCard/index";
import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
import {PostIndexedEntity} from "../../../../post/definitions/entity/Post";
import {AppService} from "../../../../../app/frontend-app/service";

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
        private feed: FeedService<PostIndexedEntity>,
        private options: FeedOptionsService,
        private appService: AppService
    ) {}
    
    getViewOption() {
        return this.options.view.current;
    } 

    hasStream() {
        if(!this.feed.isLoading()){
            this.appService.onScroll(true);
        }
        return typeof this.feed.stream === "object";
    }
}