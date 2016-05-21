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

    reset(){
        this.profileRESTService.accountCondReset();
        this.profileRESTService.personalCondReset();
       /* this.profileRESTService.interestCondReset();*/
    }

    canSave(){
        if(this.profileRESTService.accountCondToSave() ||
            this.profileRESTService.personalCondToSave()){
            return true;
        } else {
            return false;
        }
    }

    saveAllChanges(){

        /*Accont section*/
        if(this.profileRESTService.changePasswordStn.new_password === this.profileRESTService.changePasswordStn.repeat_password &&
            this.profileRESTService.changePasswordStn.new_password.length >= 3){
            this.profileRESTService.changePassword().subscribe(data => {this.modals.modals.settings.close();  this.reset()});
        }

        /*Personal section*/
        if(this.profileRESTService.personalCondToSave()){
            this.profileRESTService.editPersonal().subscribe(data => {this.modals.modals.settings.close(); this.reset()})
        }
    }

    hasChanges(): boolean {
        return false;
    }
}