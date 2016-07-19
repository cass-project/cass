import {Component} from "angular2/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {CommunityCard} from "../../../../community/component/Elements/CommunityCard/index";
import {CommunityEntity} from "../../../../community/definitions/entity/Community";

@Component({
    selector: 'cass-feed-community-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityCard,
        LoadingIndicator,
    ]
})
export class FeedCommunityStream
{
    constructor(private feed: FeedService<CommunityEntity>) {}

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}