import {Component} from "angular2/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {ProfileCard} from "../../../../profile/component/Elements/ProfileCard/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
import {ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";

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
        private feed: FeedService<ProfileIndexedEntity>,
        private options: FeedOptionsService
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }
}