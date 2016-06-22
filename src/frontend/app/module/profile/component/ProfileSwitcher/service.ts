import {Component, Injectable} from "angular2/core";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileRESTService} from "../../service/ProfileRESTService";
import {ProfileComponentService} from "../../service";
import {AuthRESTService} from "../../../auth/service/AuthRESTService";

@Injectable()
export class ProfileSwitcherService
{
    constructor(private profileRESTService: ProfileRESTService, private authRESTService: AuthRESTService) {}

    disableClick = false;

    switchProfile(profileId){
        if(!this.disableClick && AuthService.getAuthToken().getCurrentProfile().getId() !== profileId){
            this.disableClick = true;

            AuthService.getAuthToken().getCurrentProfile().entity.profile.is_current = false;

            for(let i = 0; i < AuthService.getAuthToken().account.profiles.profiles.length; i++){
                if(profileId === AuthService.getAuthToken().account.profiles.profiles[i].entity.profile.id){
                    AuthService.getAuthToken().account.profiles.profiles[i].entity.profile.is_current = true;
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
        return AuthService.getAuthToken().account.profiles.profiles;
    }
}