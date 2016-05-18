import {Injectable} from "angular2/core";
import {ProfileRESTService} from "../ProfileService/ProfileRESTService";
import {ProfileService} from "../ProfileService/ProfileService";


@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService, private profileService: ProfileService) {}

    needToSave: boolean = false;

    onChange(event){
        if(event){
            this.needToSave = true;
            console.log(this.needToSave);
        }
    }

    saveAllChanges(){

        /*Accont section*/
        if(this.profileRESTService.changePasswordStn.new_password === this.profileRESTService.changePasswordStn.repeat_password &&
            this.profileRESTService.changePasswordStn.new_password.length > 3){
            this.profileRESTService.changePassword();
        }
    }

    hasChanges(): boolean {
        return false;
    }
}