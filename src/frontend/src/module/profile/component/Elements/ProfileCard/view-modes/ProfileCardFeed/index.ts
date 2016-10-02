import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {ProfileCardHelper} from "../../helper";
import {ProfileThemeListMode} from "../../index";

@Component({
    selector: 'cass-profile-card-feed',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCardFeed
{
    @Input('profile') profile: ProfileEntity;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.InterestingIn;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.Feed;

    constructor(private helper: ProfileCardHelper) {}

    open() {
        this.openProfile.emit(this.profile);
    }

    isFemale(): boolean {
        return this.profile.gender.string === 'female';
    }

    isMale(): boolean {
        return this.profile.gender.string === 'male';
    }

    notSpecifiedGender(): boolean {
        return this.profile.gender.string === 'not-specified';
    }
}