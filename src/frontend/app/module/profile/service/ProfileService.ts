import {Injectable} from 'angular2/core';
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class ProfileService {
    constructor() {}

    interestCondReset(expertIn, interestingIn){
        for (let key in AuthService.getAuthToken().getCurrentProfile().entity.expert_in) {
            expertIn[key] = AuthService.getAuthToken().getCurrentProfile().entity.expert_in[key];
        }
        for (let key in AuthService.getAuthToken().getCurrentProfile().entity) {
            interestingIn[key] = AuthService.getAuthToken().getCurrentProfile().entity.interesting_in[key];
        }
    }

    interestCondToSave(expertIn, interestingIn){
        if(JSON.stringify(expertIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.expert_in) ||
                JSON.stringify(interestingIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.interesting_in)){
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
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        for (let key in greetings) {
            if(greetings.hasOwnProperty(key)) {
                profile.greetings[key] = AuthService.getAuthToken().getCurrentProfile().entity.greetings[key];
            }
        }

        profile.gender = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.gender));
    }

    personalCondToSave(profile) {
        if (profile.greetings.greetings_method != AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method ||
            profile.greetings.first_name != AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name ||
            profile.greetings.last_name != AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name ||
            profile.greetings.middle_name != AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name ||
            profile.greetings.nickname != AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname ||
            profile.gender.string != AuthService.getAuthToken().getCurrentProfile().entity.gender.string){
            return true;
        }
    }

    getAccountEmail(){
        return AuthService.getAuthToken().account.entity.email;
    }
}