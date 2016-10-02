import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {ProfileThemeListMode} from "../ProfileCard/index";

@Component({
    selector: 'cass-profile-cards-list',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCardsList
{
    @Input('profiles') profiles: ProfileEntity[] = [];
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Input('theme-list-mode') themeListMode: ProfileThemeListMode = ProfileThemeListMode.InterestingIn;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    isViewMode(viewMode: ViewOptionValue): boolean {
        return this.viewMode === viewMode;
    }

    open(profile: ProfileEntity) {
        this.openProfile.emit(profile);
    }
}