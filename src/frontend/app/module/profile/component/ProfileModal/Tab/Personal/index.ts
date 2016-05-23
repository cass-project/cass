import {Component} from "angular2/core";
import {FrontlineService} from "../../../../../frontline/service";
import {ProfileRESTService} from "../../../ProfileService/ProfileRESTService";
import {ProfileService} from "../../../ProfileService/ProfileService";
import {ProfileModalModel} from "../../model";

@Component({
    selector: 'cass-profile-modal-tab-personal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PersonalTab
{
    constructor(public frontlineService: FrontlineService, private profileRESTService: ProfileRESTService, private profileService: ProfileService, private model: ProfileModalModel){}


    returnActiveGreetings(value){
        if(value === this.model.greetings.greetings_method){
            return true;
        }
    }

    chooseGreetings(greetMethod){
        let greetings = this.model.greetings;
        greetings.greetings_method = greetMethod;
    }
}