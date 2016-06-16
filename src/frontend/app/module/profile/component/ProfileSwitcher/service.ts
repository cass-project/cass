import {Component, Injectable} from "angular2/core";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileComponentService} from "../../service";

@Injectable()
export class ProfileSwitcherService
{
    constructor(private profileRESTService: ProfileRESTService) {}

    disableClick = false;

    switchProfile(profileId){
        if(!this.disableClick && AuthService.getAuthToken().getCurrentProfile().getId() !== profileId){
            this.disableClick = true;

            AuthService.getAuthToken().getCurrentProfile().entity.is_current = false;

            for(let i = 0; i < AuthService.getAuthToken().account.profiles.profiles.length; i++){
                if(profileId === AuthService.getAuthToken().account.profiles.profiles[i].entity.id){
                    AuthService.getAuthToken().account.profiles.profiles[i].entity.is_current = true;
                }
            }

            this.profileRESTService.switchProfile(profileId).subscribe(data => {
                window.location.reload();
            });
        }
    }


    signOut(){
        this.profileRESTService.signOut();
    }

    getProfiles(){
        return AuthService.getAuthToken().account.profiles.profiles;
    }
}