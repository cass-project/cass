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

    personalCondReset(profile){
        for (let key in this.frontlineService.session.auth.profiles[0].greetings) {
            profile.greetings[key] = this.frontlineService.session.auth.profiles[0].greetings[key];
        };
        profile.gender = this.frontlineService.session.auth.profiles[0].gender;
    }

    personalCondToSave(profile) {
        if (profile.greetings.greetings_method != this.frontlineService.session.auth.profiles[0].greetings.greetings_method ||
            profile.greetings.first_name != this.frontlineService.session.auth.profiles[0].greetings.first_name ||
            profile.greetings.last_name != this.frontlineService.session.auth.profiles[0].greetings.last_name ||
            profile.greetings.middle_name != this.frontlineService.session.auth.profiles[0].greetings.middle_name ||
            profile.greetings.nickname != this.frontlineService.session.auth.profiles[0].greetings.nickname ||
            profile.gender.string != this.frontlineService.session.auth.profiles[0].gender.string){
            return true;
        }
    }

    getAccountEmail(){
        return this.frontlineService.session.auth.account.email;
    }

}