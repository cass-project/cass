import {Injectable} from 'angular2/core';
import {frontline, FrontlineService} from "../../../frontline/service";

@Injectable()
export class ProfileService {
    constructor(public frontlineService:FrontlineService) {}


    changePasswordStn = {old_password: '', new_password: '', repeat_password: ''};
    greetings = {
        id: 0,
        profile_id: 0,
        first_name: '',
        last_name: '',
        middle_name: '',
        nickname: '',
        greetings: '',
        greetings_method: ''
    };

    inInterestingZone: boolean = true;
    inExpertZone: boolean = false;
    /*expertIn = Object.create(this.frontlineService.session.auth.profiles[0].expert_in);*/
    expertIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in))); //Nice method to clone object, lol
    interestingIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)));


    interestCondReset(){
        this.expertIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in)));
        this.interestingIn = (JSON.parse(JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)));
    }

    interestCondToSave(){
        if(JSON.stringify(this.expertIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in) ||
            JSON.stringify(this.interestingIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)){
            console.log(JSON.stringify(this.expertIn), JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in));
            return true;
        } else {
            return false;
        }
    }

    accountCondReset(){
        this.changePasswordStn.old_password = '';
        this.changePasswordStn.new_password = '';
        this.changePasswordStn.repeat_password = '';
    }

    accountCondToSave(){
        if(this.changePasswordStn.new_password.length > 0 &&
            this.changePasswordStn.repeat_password.length > 0 &&
            this.changePasswordStn.new_password === this.changePasswordStn.repeat_password &&
            this.changePasswordStn.new_password !== this.changePasswordStn.old_password){
            return true;
        } else if(this.changePasswordStn.new_password.length > 0 &&
            this.changePasswordStn.repeat_password.length > 0 &&
            this.changePasswordStn.new_password === this.changePasswordStn.old_password &&
            this.changePasswordStn.repeat_password === this.changePasswordStn.old_password){
            console.log("Старый и новые пароли совпадают");
        }
    }

    personalCondReset(){
        for (let key in this.frontlineService.session.auth.profiles[0].greetings) {
            this.greetings[key] = this.frontlineService.session.auth.profiles[0].greetings[key];
        }
    }

    personalCondToSave() {
        if (this.greetings.id === 0) {
            this.personalCondReset()
        } else if (this.greetings.greetings_method != this.frontlineService.session.auth.profiles[0].greetings.greetings_method ||
            this.greetings.first_name != this.frontlineService.session.auth.profiles[0].greetings.first_name ||
            this.greetings.last_name != this.frontlineService.session.auth.profiles[0].greetings.last_name ||
            this.greetings.middle_name != this.frontlineService.session.auth.profiles[0].greetings.middle_name ||
            this.greetings.nickname != this.frontlineService.session.auth.profiles[0].greetings.nickname) {
            return true;
        }
    }

    getAccountEmail(){
        return this.frontlineService.session.auth.account.email;
    }

}