import {Component, ViewEncapsulation} from "angular2/core";
import {AuthService} from '../../../../../auth/service/AuthService';
import {Profile} from "../../../../../profile/entity/Profile";
import {ROUTER_DIRECTIVES} from "angular2/router";

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
    public getTitle(): string {
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