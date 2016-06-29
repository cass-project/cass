import {Injectable} from 'angular2/core';
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class ProfileService {
    constructor(private authService: AuthService) {}

    interestCondReset(expertIn, interestingIn){
        for (let key in this.authService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids) {
            expertIn[key] = this.authService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids[key];
        }
        for (let key in this.authService.getAuthToken().getCurrentProfile().entity.profile) {
            interestingIn[key] = this.authService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids[key];
        }
    }

    interestCondToSave(expertIn, interestingIn){
        if(JSON.stringify(expertIn) != JSON.stringify(this.authService.getAuthToken().getCurrentProfile().entity.profile.expert_in_ids) ||
                JSON.stringify(interestingIn) != JSON.stringify(this.authService.getAuthToken().getCurrentProfile().entity.profile.interesting_in_ids)){
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
        let greetings = this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings;

        for (let key in greetings) {
            if(greetings.hasOwnProperty(key)) {
                profile.greetings[key] = this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings[key];
            }
        }

        profile.gender = JSON.parse(JSON.stringify(this.authService.getAuthToken().getCurrentProfile().entity.profile.gender));
    }

    personalCondToSave(profile) {
        if (profile.greetings.greetings_method != this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings.greetings ||
            profile.greetings.first_name != this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings.first_name ||
            profile.greetings.last_name != this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings.last_name ||
            profile.greetings.middle_name != this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings.middle_name ||
            profile.greetings.nickname != this.authService.getAuthToken().getCurrentProfile().entity.profile.greetings.nick_name ||
            profile.gender.string != this.authService.getAuthToken().getCurrentProfile().entity.profile.gender.string){
            return true;
        }
    }

    getAccountEmail(){
        return this.authService.getAuthToken().account.entity.email;
    }
}