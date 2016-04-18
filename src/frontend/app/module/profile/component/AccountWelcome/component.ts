import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropper} from "../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileWelcomeInfo} from "../../service/ProfileService";
import {Profile} from "../../entity/Profile";
import {AvatarCropperService} from "../AvatarCropper/service";
import {AccountConfirm} from "./Confirm/component";
import {AccountWelcomeHome} from "./AccountWelcomeHome/component";

declare var Cropper;

@Component({
    template: require('./template.html'),
    'providers': [
        ProfileService,
        AvatarCropperService,
        AuthService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})

@RouteConfig([
    {
        useAsDefault: true,
        name: 'Home',
        path: '/',
        component: AccountWelcomeHome
    },
    {
        name: 'Confirm',
        path: '/confirm',
        component: AccountConfirm
    }
])

@Injectable()
export class AccountWelcome {
}

