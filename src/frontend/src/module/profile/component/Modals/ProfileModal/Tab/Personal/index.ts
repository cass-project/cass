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

    isGender(value) {
        return (value === this.model.profile.gender.string)
    }

    selectGender(value){
        this.model.profile.gender.string = value;
    }

    isGreetings(value){
        return (value === this.model.profile.greetings.method);
    }

    selectGreetings(greetMethod){
        this.model.profile.greetings.method = greetMethod;
    }
}