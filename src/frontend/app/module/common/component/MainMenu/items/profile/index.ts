import {Component, ViewEncapsulation} from "angular2/core";
import {AuthService} from '../../../../../auth/service/AuthService';
import {Profile} from "../../../../../profile/entity/Profile";
import {ROUTER_DIRECTIVES} from "angular2/router";
import {ProfileInfo} from "../../../../../profile/service/ProfileService";

@Component({ // 1
    selector: "main-menu-item-profile",
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class MainMenuProfileItem
{

    getProfileName(){
        if(this.getGreetings()){
            switch(AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method){
                case 'fl': return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name}`;
                    break;
                case 'flm': return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.first_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.last_name} ${AuthService.getAuthToken().getCurrentProfile().entity.greetings.middle_name}`;
                    break;
                case 'n': return `${AuthService.getAuthToken().getCurrentProfile().entity.greetings.nickname}`;
                    break;
            }
        } else return this.getGreetings();

    }


    public getGreetings() {
        return AuthService.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().greetings()
            : 'Anonymous';
    }

    public getDescription(): string {
        return "Dashboard, your collections and settings";
    }

    public getImageSrc() {
        return AuthService.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().entity.image.public_path
            : Profile.AVATAR_DEFAULT;
    }
}