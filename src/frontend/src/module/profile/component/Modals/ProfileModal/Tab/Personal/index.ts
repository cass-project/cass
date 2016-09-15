import {Component} from "@angular/core";
import {ProfileModalModel} from "../../model";


@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-profile-modal-tab-personal'})

export class PersonalTab
{
    constructor(private model: ProfileModalModel){}


    getActiveSex(value){
        return (value === this.model.profile.gender.string)
    }

    chooseGender(value){
        this.model.profile.gender.string = value;
    }

    getActiveGreetings(value){
        return (value === this.model.profile.greetings.method);
    }

    chooseGreetings(greetMethod){
        this.model.profile.greetings.method = greetMethod;
    }
}