import {Component} from "@angular/core";
import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {ProfileIndexedEntity} from "../../../../profile/definitions/entity/Profile";
import {AppService} from "../../../../../app/frontend-app/service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-feed-profile-stream'})

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