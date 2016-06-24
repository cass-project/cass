import {Component, EventEmitter, Output} from "angular2/core";
import {ProfileSetupModel} from "../../model";
import {ProfileSetup} from "../../index";

@Component({
    selector: 'cass-profile-setup-screen-gender',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSetupScreenGender
{
    @Output("choice") choiceEvent = new EventEmitter<string>();

    constructor(private model: ProfileSetupModel){}


    setGender(value){
        this.choiceEvent.emit(value);
    }
}