import {Component, EventEmitter, Output} from "@angular/core";

import {ProfileSetupModel} from "../../model";
import {ProfileGender} from "../../../../../definitions/entity/Profile";

@Component({
    selector: 'cass-profile-setup-screen-gender',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSetupScreenGender
{
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    constructor(private model: ProfileSetupModel) {}

    useGender(gender: ProfileGender) {
        this.model.useGender(gender);
        this.nextEvent.emit(this.model);
    }
    
    skip() {
        this.model.useGender(ProfileGender.None);
        this.nextEvent.emit(this.model);
    }
}