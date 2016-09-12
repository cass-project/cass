import {Component, EventEmitter, Output, Directive} from "@angular/core";

import {ProfileSetupModel} from "../../model";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-profile-setup'})

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