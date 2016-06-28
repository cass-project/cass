import {Component, Output, EventEmitter} from "angular2/core";

import {ProfileSetupModel} from "../../model";
import {ThemeSelect} from "../../../../../../theme/component/ThemeSelect/index";

@Component({
    selector: 'cass-profile-setup-screen-interests',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ThemeSelect,
    ]
})
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