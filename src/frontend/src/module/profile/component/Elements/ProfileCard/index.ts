import {Component, Input, Output, EventEmitter, OnChanges} from "@angular/core";

import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ProfileCardFeed} from "./view-modes/ProfileCardFeed/index";
import {ProfileCardGrid} from "./view-modes/ProfileCardGrid/index";
import {ProfileCardList} from "./view-modes/ProfileCardList/index";
import {ProfileCardHelper} from "./helper";

@Component({
    selector: 'cass-profile-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ProfileCardHelper,
    ]
})
export class ProfileCard implements OnChanges {
    @Input('profile') profile: ProfileEntity;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.InterestingIn;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    constructor(private helper: ProfileCardHelper) {}

    ngOnChanges() {
        this.helper.setProfile(this.profile, this.themeListMode);
    }

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    open() {
        this.openProfile.emit(this.profile);
    }
}

export const PROFILE_CARD_DIRECTIVES = [
    ProfileCard,
    ProfileCardFeed,
    ProfileCardGrid,
    ProfileCardList,
];

export enum ProfileThemeListMode {
    InterestingIn = <any>"interesting-in",
    ExpertIn = <any>"expert-in",
}