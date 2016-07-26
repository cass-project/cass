import {Component, ViewChild, ElementRef} from "angular2/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {CommunityCard} from "../../../../community/component/Elements/CommunityCard/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
import {CommunityIndexedEntity} from "../../../../community/definitions/entity/Community";

@Component({
    selector: 'cass-feed-community-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        CommunityCard,
        LoadingIndicator,
        FeedScrollDetector
    ]
})
export class FeedCommunityStream
{
    constructor(
        private feed: FeedService<CommunityIndexedEntity>,
        private options: FeedOptionsService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}