import {Component, Input, Output, EventEmitter} from "@angular/core";

import {ProfileEntity} from "../../../../../definitions/entity/Profile";
import {ViewOptionValue} from "../../../../../../feed/service/FeedService/options/ViewOption";

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
    @Output('open') openProfile: EventEmitter<ProfileEntity> = new EventEmitter<ProfileEntity>();

    private viewMode: ViewOptionValue = ViewOptionValue.List;

    open() {
        this.openProfile.emit(this.profile);
    }
}