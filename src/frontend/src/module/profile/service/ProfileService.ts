import {Injectable} from 'angular2/core';
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class ProfileService {
    constructor() {}

    interestCondReset(expertIn, interestingIn){
        for (let key in AuthService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids) {
            expertIn[key] = AuthService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids[key];
        }
        for (let key in AuthService.getAuthToken().getCurrentProfile().entity.profile) {
            interestingIn[key] = AuthService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids[key];
        }
    }

    interestCondToSave(expertIn, interestingIn){
        if(JSON.stringify(expertIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids) ||
                JSON.stringify(interestingIn) != JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids)){
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
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings;

        for (let key in greetings) {
            if(greetings.hasOwnProperty(key)) {
                profile.greetings[key] = AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings[key];
            }
        }

        profile.gender = JSON.parse(JSON.stringify(AuthService.getAuthToken().getCurrentProfile().entity.profile.gender));
    }

    personalCondToSave(profile) {
        if (profile.greetings.greetings_method != AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings.greetings ||
            profile.greetings.first_name != AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings.first_name ||
            profile.greetings.last_name != AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings.last_name ||
            profile.greetings.middle_name != AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings.middle_name ||
            profile.greetings.nickname != AuthService.getAuthToken().getCurrentProfile().entity.profile.greetings.nick_name ||
            profile.gender.string != AuthService.getAuthToken().getCurrentProfile().entity.profile.gender.string){
            return true;
        }
    }

    getAccountEmail(){
        return AuthService.getAuthToken().account.entity.email;
    }
}