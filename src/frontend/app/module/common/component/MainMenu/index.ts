import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES, Router} from 'angular2/router'
import {AuthService} from '../../../auth/service/AuthService';
import {Profile} from "../../../profile/entity/Profile";

@Component({
    selector: 'cass-main-menu',
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ],
    styles: [
        require('./style.shadow.scss')
    ]
})
export class MainMenu
{
    constructor(private authService: AuthService, private router: Router) {}

    isSignedIn() {
        return AuthService.isSignedIn();
    }

    getGreetings() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().greetings
            : 'Anonymous'
        ;
    }

    getProfileAvatar() {
        return this.isSignedIn()
            ? AuthService.getAuthToken().getCurrentProfile().entity.image.public_path
            : Profile.AVATAR_DEFAULT;
    }


    signOut() {
        this.authService.signOut().add(() => {
            this.router.navigate(['/Auth/Logout']);
        })
    }
}