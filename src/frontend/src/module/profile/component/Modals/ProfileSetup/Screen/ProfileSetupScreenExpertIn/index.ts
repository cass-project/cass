import {Component, EventEmitter, Output} from "@angular/core";

import {ProfileSetupModel} from "../../model";

@Component({
    selector: 'cass-profile-setup-screen-expert-in',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSetupScreenExpertIn
{
    @Output('back') backEvent = new EventEmitter<ProfileSetupModel>();
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    constructor(private model: ProfileSetupModel) {}

    back() {
        this.backEvent.emit(this.model);
    }

    finish() {
        this.nextEvent.emit(this.model);
    }
}