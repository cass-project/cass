import {Injectable} from "angular2/core";
import {ProfileRESTService} from "../ProfileService/ProfileRESTService";
import {ProfileService} from "../ProfileService/ProfileService";
import {ProfileComponentService} from "../../service";


@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService, private profileService: ProfileService, private modals: ProfileComponentService) {}

    needToSave: boolean = false;

    cancel(){
        this.profileRESTService.changePasswordStn.old_password = '';
        this.profileRESTService.changePasswordStn.new_password = '';
        this.profileRESTService.changePasswordStn.repeat_password = '';

        this.needToSave = false;
    }

    canSave(){
        if(this.needToSave && this.profileRESTService.changePasswordStn.new_password === this.profileRESTService.changePasswordStn.repeat_password){
            return true;
        }
    }

    onChange(event){
        if(event) {
            this.needToSave = true;
        }
    }

    saveAllChanges(){

        /*Accont section*/
        if(this.profileRESTService.changePasswordStn.new_password === this.profileRESTService.changePasswordStn.repeat_password &&
            this.profileRESTService.changePasswordStn.new_password.length >= 3){
            this.profileRESTService.changePassword().subscribe(data => {this.modals.modals.settings.close()});
        }
    }

    hasChanges(): boolean {
        return false;
    }
}