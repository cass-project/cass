import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {CommunityIndexedEntity, CommunityEntity} from "../../../../community/definitions/entity/Community";
import {CommunityService} from "../../../../community/service/CommunityService";

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
        private community: CommunityService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }

    open($event: CommunityEntity) {
        this.community.navigateCommunity($event);
    }
}