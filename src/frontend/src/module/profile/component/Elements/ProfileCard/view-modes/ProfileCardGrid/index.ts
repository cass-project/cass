import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";
import {ProfileCardHelper} from "../../helper";
import {ProfileThemeListMode} from "../../index";

@Component({
    selector: 'cass-profile-card-grid',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
        require('./style.navigation.shadow.scss'),
    ]
})
export class ProfileCardGrid
{
    @Input('profile') profile: ProfileEntity;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.ExpertIn;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.Grid;

    constructor(private helper: ProfileCardHelper) {}

    open() {
        this.openProfile.emit(this.profile);
    }
}