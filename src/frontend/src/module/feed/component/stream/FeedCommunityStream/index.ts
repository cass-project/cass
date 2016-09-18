import {Component} from "@angular/core";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {CommunityIndexedEntity} from "../../../../community/definitions/entity/Community";
import {AppService} from "../../../../../app/frontend-app/service";

@Component({
    selector: 'cass-feed-community-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedCommunityStream
{
    constructor(
        private feed: FeedService<CommunityIndexedEntity>,
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