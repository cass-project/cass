import {Injectable} from 'angular2/core';
import {frontline, FrontlineService} from "../../../frontline/service";

@Injectable()
export class ProfileService {
    constructor(public frontlineService:FrontlineService) {}

    interestCondReset(expertIn, interestingIn){
        for (let key in this.frontlineService.session.auth.profiles[0].expert_in) {
            expertIn[key] = this.frontlineService.session.auth.profiles[0].expert_in[key];
        }
        for (let key in this.frontlineService.session.auth.profiles[0].interesting_in) {
            interestingIn[key] = this.frontlineService.session.auth.profiles[0].interesting_in[key];
        }
    }

    interestCondToSave(expertIn, interestingIn){
        if(JSON.stringify(expertIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].expert_in) ||
            JSON.stringify(interestingIn) != JSON.stringify(this.frontlineService.session.auth.profiles[0].interesting_in)){
            return true;
        } else {
            return false;
        }
    }

    accountCondReset(changePasswordStn){
        changePasswordStn.old_password = '';
        changePasswordStn.new_password = '';
        changePasswordStn.repeat_password = '';
    }

    accountCondToSave(changePasswordStn){
        if(changePasswordStn.new_password.length > 0 &&
            changePasswordStn.repeat_password.length > 0 &&
            changePasswordStn.new_password === changePasswordStn.repeat_password &&
            changePasswordStn.new_password !== changePasswordStn.old_password){
            return true;
        } else if(changePasswordStn.new_password.length > 0 &&
            changePasswordStn.repeat_password.length > 0 &&
            changePasswordStn.new_password === changePasswordStn.old_password &&
            changePasswordStn.repeat_password === changePasswordStn.old_password){
            console.log("Старый и новые пароли совпадают");
        }
    }

    personalCondReset(greetings){
        for (let key in this.frontlineService.session.auth.profiles[0].greetings) {
            greetings[key] = this.frontlineService.session.auth.profiles[0].greetings[key];
        }
    }

    personalCondToSave(greetings) {
        if (greetings.id === 0) {
            this.personalCondReset(greetings);
        } else if (greetings.greetings_method != this.frontlineService.session.auth.profiles[0].greetings.greetings_method ||
            greetings.first_name != this.frontlineService.session.auth.profiles[0].greetings.first_name ||
            greetings.last_name != this.frontlineService.session.auth.profiles[0].greetings.last_name ||
            greetings.middle_name != this.frontlineService.session.auth.profiles[0].greetings.middle_name ||
            greetings.nickname != this.frontlineService.session.auth.profiles[0].greetings.nickname) {
            return true;
        }
    }

    getAccountEmail(){
        return this.frontlineService.session.auth.account.email;
    }

}