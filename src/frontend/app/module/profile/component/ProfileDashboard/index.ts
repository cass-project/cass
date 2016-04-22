import {Component} from 'angular2/core';
import {AuthService} from "../../../auth/service/AuthService";
import {ROUTER_DIRECTIVES, RouteConfig, Router} from "angular2/router";
import {Profile} from "../../entity/Profile";
import {AvatarCropperService} from "../AvatarCropper/service";
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropper} from "../AvatarCropper/index";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES,
        AvatarCropper
    ],
    'providers': [
        ProfileService,
        AvatarCropperService
    ]
})
export class ProfileDashboardComponent {

    constructor(public router:Router,
                public avatarCropperService: AvatarCropperService
    ) {
    }

    ngOnInit() {
        if (!AuthService.getAuthToken().getCurrentProfile().entity.is_initialized) {
            this.router.parent.navigate(['Welcome']);
        }
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    getProfileName() {
        let greetings = AuthService.getAuthToken().getCurrentProfile().entity.greetings;

        if (AuthService.getGreetings()) {
            switch (greetings.greetings_method) {
                case 'fl':
                    return `${greetings.first_name} ${greetings.last_name}`;
                    break;
                case 'flm':
                    return `${greetings.first_name} ${greetings.last_name} ${greetings.middle_name}`;
                    break;
                case 'n':
                    return `${greetings.nickname}`;
                    break;
            }
        }
    }

    getProfileAvatar() {
            return AuthService.isSignedIn()
                ? AuthService.getAuthToken().getCurrentProfile().entity.image.public_path
                : Profile.AVATAR_DEFAULT;
    }
}