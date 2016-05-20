import {Injectable} from "angular2/core";
import {ProfileRESTService} from "../ProfileService/ProfileRESTService";
import {ProfileService} from "../ProfileService/ProfileService";
import {ProfileComponentService} from "../../service";
import {ThemeSelect} from "../../../theme/component/ThemeSelect/index";


@Injectable()
export class ProfileModalModel
{
    constructor(private profileRESTService: ProfileRESTService,
                private profileService: ProfileService,
                private modals: ProfileComponentService) {}

    needToSave: boolean = false;

    cancel(){
        this.profileRESTService.accountCondReset();
       /* this.profileRESTService.interestCondReset();*/
    }

    canSave(){
        if(this.profileRESTService.accountCondToSave() /*||
            this.profileRESTService.interestCondToSave()*/){
            return true;
        } else {
            return false;
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