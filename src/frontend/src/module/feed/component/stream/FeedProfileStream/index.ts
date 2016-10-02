import {Component} from "@angular/core";

import {FeedService} from "../../../service/FeedService/index";
import {FeedOptionsService} from "../../../service/FeedOptionsService";
import {ProfileIndexedEntity, ProfileEntity} from "../../../../profile/definitions/entity/Profile";
import {Router} from "@angular/router";

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
        private router: Router
    ) {}

    getViewOption() {
        return this.options.view.current;
    }

    hasStream() {
        return typeof this.feed.stream === "object";
    }

    openProfile(profile: ProfileEntity) {
        this.router.navigate(['/profile', profile.id]);
    }
}