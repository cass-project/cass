import {Injectable} from "@angular/core";

import {ProfileRESTService} from "../../../../../service/ProfileRESTService";
import {AuthService} from "../../../../../../auth/service/AuthService";
import {Session} from "../../../../../../session/Session";


@Injectable()
export class ProfilesTabService
{
    constructor(
        private profileRESTService: ProfileRESTService,
        private authService: AuthService,
        private session: Session
    ) {}

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
            window.location.reload();
        });
    }

    requestDeleteProfile(profileId){
        this.buttonActivate = true;
        this.profileRESTService.deleteProfile(profileId).subscribe(data => {
            this.session.getCurrentAccount().profiles.profiles.splice(this.pickedElem, 1);

            this.closeModalDeleteProfile();
            this.buttonActivate = false;
        });
    }

    getProfile(){
        for(let i = 0; i < this.authService.getCurrentAccount().profiles.profiles.length; i++){
            if(this.pickedId === this.authService.getCurrentAccount().profiles.profiles[i].entity.profile.id){
                this.pickedElem = i;
                return this.authService.getCurrentAccount().profiles.profiles[i].entity.profile;
            }
        }
    }
    
    getProfiles(){
        return this.authService.getCurrentAccount().profiles.profiles;
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