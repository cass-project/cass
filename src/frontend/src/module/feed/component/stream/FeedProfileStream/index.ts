import {Component} from "@angular/core";

import {LoadingIndicator} from "../../../../form/component/LoadingIndicator/index";
import {FeedService} from "../../../service/FeedService/index";
import {ProfileCard} from "../../../../profile/component/Elements/ProfileCard/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {FeedScrollDetector} from "../../FeedScrollDetector/index";
import {ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";
import {AppService} from "../../../../../app/frontend-app/service";

@Component({
    selector: 'cass-feed-profile-stream',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class FeedProfileStream
{
    constructor(
        private feed: FeedService<ProfileIndexedEntity>,
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