import {Component, Injectable} from "angular2/core";

import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileRESTService} from "../../../service/ProfileRESTService";
import {AuthRESTService} from "../../../../auth/service/AuthRESTService";

@Injectable()
export class ProfileSwitcherService
{
    constructor(
        private profileRESTService: ProfileRESTService, 
        private authRESTService: AuthRESTService,
        private authService: AuthService
    ) {}

    disableClick = false;

    switchProfile(profileId){
        if(!this.disableClick && this.authService.getAuthToken().getCurrentProfile().getId() !== profileId){
            this.disableClick = true;

            this.authService.getAuthToken().getCurrentProfile().entity.profile.is_current = false;

            for(let i = 0; i < this.authService.getAuthToken().account.profiles.profiles.length; i++){
                if(profileId === this.authService.getAuthToken().account.profiles.profiles[i].entity.profile.id){
                    this.authService.getAuthToken().account.profiles.profiles[i].entity.profile.is_current = true;
                }
            }

            this.profileRESTService.switchProfile(profileId).subscribe(data => {
                window.location.reload();
            });
        }
    }


    signOut(){
        this.authRESTService.signOut();
    }

    getProfiles(){
        return this.authService.getAuthToken().account.profiles.profiles;
    }
}