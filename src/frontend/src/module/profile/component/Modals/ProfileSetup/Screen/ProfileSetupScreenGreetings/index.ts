import {Component, Output, EventEmitter} from "angular2/core";

import {ProfileSetupModel} from "../../model";

@Component({
    selector: 'cass-profile-setup-screen-greetings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSetupScreenGreetings
{
    @Output('back') backEvent = new EventEmitter<ProfileSetupModel>();
    @Output('next') nextEvent = new EventEmitter<ProfileSetupModel>();

    constructor(private model: ProfileSetupModel) {}

    back() {
        this.backEvent.emit(this.model);
    }

    submit() {
        this.nextEvent.emit(this.model);
    }
}