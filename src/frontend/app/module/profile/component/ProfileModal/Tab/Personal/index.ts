import {Component} from "angular2/core";
import {FrontlineService} from "../../../../../frontline/service";

@Component({
    selector: 'cass-profile-modal-tab-personal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PersonalTab
{
    constructor(public frontline: FrontlineService){}

    greetings = {
        firstname_lastname: false,
        nickname: false,
        middlename_firstname: false,
        lastname_firstname_middlename: false
    };

    returnActiveGreetings(){
        let greetingsMethod = this.frontline.session.auth.profiles[0].greetings.greetings_method;
        switch(greetingsMethod){
            case 'fl':
                this.greetings.firstname_lastname = true;
                this.greetings.lastname_firstname_middlename = false;
                this.greetings.middlename_firstname = false;
                this.greetings.nickname = false;
                break;
            case 'n':
                this.greetings.nickname = true;
                this.greetings.firstname_lastname = false;
                this.greetings.lastname_firstname_middlename = false;
                this.greetings.middlename_firstname = false;
                break;
            case 'lfm':
                this.greetings.lastname_firstname_middlename = true;
                this.greetings.middlename_firstname = false;
                this.greetings.nickname = false;
                this.greetings.firstname_lastname = false;
                break;
            case 'mf':
                this.greetings.middlename_firstname = true;
                this.greetings.nickname = false;
                this.greetings.firstname_lastname = false;
                this.greetings.lastname_firstname_middlename = false;
                break;
        }
    }


    chooseGreetings(greet){
        greet = true;
    }
}