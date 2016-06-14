import {Component} from "angular2/core";
import {FrontlineService} from "../../../../../frontline/service";
import {ProfileRESTService} from "../../../../service/ProfileRESTService";
import {ProfileService} from "../../../../service/ProfileService";
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


    getActiveSex(value){
        if(value === this.model.profile.gender.string){
            return true;
        } else if(value === 'none'){
            return true;
        }
    }

    chooseSex(sex){
        this.model.profile.gender.string = sex;
    }

    getActiveGreetings(value){
        if(value === this.model.profile.greetings.greetings_method){
            return true;
        }
    }

    chooseGreetings(greetMethod){
        this.model.profile.greetings.greetings_method = greetMethod;
    }
}