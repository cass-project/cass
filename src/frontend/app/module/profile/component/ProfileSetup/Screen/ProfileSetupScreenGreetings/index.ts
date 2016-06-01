import {Component} from "angular2/core";
import {ProfileSetupModel} from "../../model";

@Component({
    selector: 'cass-profile-setup-screen-greetings',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ProfileSetupScreenGreetings
{
    constructor(private model: ProfileSetupModel){}

    getGreetingMethod(value){
        if(value === this.model.greetings.greetings_method){
            return true;
        }
    }

    chooseGreetingMethod(value){
        this.model.greetings.greetings_method = value;
    }
}