import {Injectable} from "angular2/core";
import {ThemeService} from "../../../../../theme/service/ThemeService";
import {ProfileRESTService} from "../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../auth/service/AuthService";

@Injectable()
export class ProfilesTabService
{
    constructor(private profileRESTService: ProfileRESTService) {}

    private createNewProfileButton: boolean = true;
    private modalSwitchActive: boolean = false;
    private modalDeleteActive: boolean = false;
    private newProfileId;
    private pickedId;
    private pickedElem;

    buttonActivate: boolean = false;

    getActiveCreateNewProfileButton(): boolean{
        return this.createNewProfileButton;
    }

    switchProfile(profileId){
        this.buttonActivate = true;
        this.profileRESTService.switchProfile(profileId).subscribe(data => {
            window.location.reload();
        });
    }

    createNewProfile() {
        this.createNewProfileButton = false;
        this.profileRESTService.createNewProfile().subscribe(data => {
            this.newProfileId = data;
            this.newProfileId = JSON.parse(this.newProfileId._body).entity.id;
            window.location.reload();
        });
    }

    requestDeleteProfile(profileId){
        this.buttonActivate = true;
        this.profileRESTService.deleteProfile(profileId).subscribe(data => {
            AuthService.getAuthToken().account.profiles.profiles.splice(this.pickedElem, 1);
            console.log(AuthService.getAuthToken().account.profiles.profiles, this.pickedElem);
            this.closeModalDeleteProfile();
            this.buttonActivate = false;
        });
    }

    getProfile(){
        for(let i = 0; i < AuthService.getAuthToken().account.profiles.profiles.length; i++){
            if(this.pickedId === AuthService.getAuthToken().account.profiles.profiles[i].entity.profile.id){
                this.pickedElem = i;
                return AuthService.getAuthToken().account.profiles.profiles[i].entity;
            }
        }
    }

    getProfiles(){
        return AuthService.getAuthToken().account.profiles.profiles;
    }

    closeModalDeleteProfile(){
        this.modalDeleteActive = false;
    }

    openModalDeleteProfile(profileId){
        this.modalDeleteActive = true;
        this.pickedId = profileId;
    }

    isModalSwitchProfileActive(): boolean {
        return this.modalSwitchActive;
    }

    isModalDeleteProfileActive(): boolean {
        return this.modalDeleteActive;
    }
}