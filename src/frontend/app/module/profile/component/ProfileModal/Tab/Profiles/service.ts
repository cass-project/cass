import {Injectable} from "angular2/core";
import {ThemeService} from "../../../../../theme/service/ThemeService";
import {ProfileRESTService} from "../../../ProfileService/ProfileRESTService";
import {ProfileComponentService} from "../../../../service";
import {AuthService} from "../../../../../auth/service/AuthService";

@Injectable()
export class ProfilesTabService
{
    constructor(private profileRESTService: ProfileRESTService, private pService: ProfileComponentService){}

    private modalSwitchActive: boolean = false;
    private modalDeleteActive: boolean = false;
    private newProfileId;

    createNewProfile() {


        this.profileRESTService.createNewProfile().subscribe(data => {
            this.newProfileId = data;
            this.newProfileId = JSON.parse(this.newProfileId._body).entity.id;
            this.pService.modals.setup.open();
        });

    }


    returnProfiles(){
        return AuthService.getAuthToken().account.profiles.profiles;
    }

    closeModalDeleteProfile(){
        this.modalDeleteActive = false;
    }

    openModalDeleteProfile(){
        this.modalDeleteActive = true;
    }

    isModalSwitchProfileActive(): boolean {
        return this.modalSwitchActive;
    }

    isModalDeleteProfileActive(): boolean {
        return this.modalDeleteActive;
    }
}