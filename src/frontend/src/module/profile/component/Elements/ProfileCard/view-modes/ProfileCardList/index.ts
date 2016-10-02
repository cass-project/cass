import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {ProfileCardHelper} from "../../helper";
import {ProfileThemeListMode} from "../../index";

@Component({
    selector: 'cass-profile-card-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCardList
{
    @Input('profile') profile: ProfileEntity;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.InterestingIn;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.List;

    constructor(private helper: ProfileCardHelper) {}

    open($event) {
        $event.preventDefault();

        this.openProfile.emit(this.profile);
    }
}