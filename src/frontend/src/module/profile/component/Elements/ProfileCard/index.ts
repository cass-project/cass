import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ViewOptionValue} from "../../../../feed/service/FeedService/options/ViewOption";
import {ProfileEntity} from "../../../definitions/entity/Profile";
import {ProfileCardFeed} from "./view-modes/ProfileCardFeed/index";
import {ProfileCardGrid} from "./view-modes/ProfileCardGrid/index";
import {ProfileCardList} from "./view-modes/ProfileCardList/index";

@Component({
    selector: 'cass-profile-card',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileCard {
    @Input('profile') profile: ProfileEntity;
    @Input('view-mode') viewMode: ViewOptionValue = ViewOptionValue.Feed;
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

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