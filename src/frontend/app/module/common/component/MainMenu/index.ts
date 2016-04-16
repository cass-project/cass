import {Component} from 'angular2/core';
import {ROUTER_DIRECTIVES} from 'angular2/router'
import {AuthService} from '../../../auth/service/AuthService';
import {Profile} from "../../../profile/service/CurrentProfileService";
import {CurrentProfileService} from "../../../profile/service/CurrentProfileService";

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

    Name: String = "Eric Evance";
    constructor(private authService: AuthService,
                public currentProfileService: CurrentProfileService
    ) {}

    navElementClicked: boolean = false;

    showSignOut() {
        return this.authService.signedIn;
    }
}