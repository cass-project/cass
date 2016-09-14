import {Component, Output, EventEmitter, Directive} from "@angular/core";

import {ProfileSetupModel} from "../../model";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-setup-screen-interests'})

export class ProfileSetupScreenInterests
{
    @Output('back') backEvent = new EventEmitter<ProfileSetupModel>();
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    constructor(private model: ProfileSetupModel){}

    back() {
        this.backEvent.emit(this.model);
    }

    next() {
        this.nextEvent.emit(this.model);
    }

    skip() {
        this.nextEvent.emit(this.model);
    }
}