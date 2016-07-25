import {Component, ViewChild, ElementRef} from "angular2/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {ProfileCard} from "../../../../profile/component/Elements/ProfileCard/index";
import {ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";

@Component({
    selector: 'cass-feed-profile-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileCard,
        LoadingIndicator,
        FeedScrollDetector
    ]
})
export class FeedProfileStream
{
    constructor(
        private feed: FeedService<ProfileEntity>,
        private options: FeedOptionsService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}