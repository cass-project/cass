import {Component, Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {AvatarCropper} from "./AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AccountWelcomeService} from "./service";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileWelcomeInfo} from "../../service/CurrentProfileRestService";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService,
        AccountWelcomeService,
        AuthService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})

@Injectable()
export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService,
                 public router: Router,
                 public accountWelcomeService: AccountWelcomeService,
                 public authService: AuthService
    ){}


    profileInfo: ProfileWelcomeInfo = new ProfileWelcomeInfo();

    preInfo: boolean = false;

    chooseType: boolean = true;
    chooseFL: boolean = false;
    chooseLFM: boolean = false;
    chooseN: boolean = false;

    NextShow: boolean = false;
    SubmitShow: boolean = false;
    PreInfo: boolean = false;

    showAvatarCropper() {
        this.accountWelcomeService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.accountWelcomeService.isAvatarFormVisibleFlag;
    }

    reset(){
        this.router.parent.navigate(['Profile']);
        this.router.parent.navigate(['Welcome']);
    }

    ngSubmit(){
        this.router.navigate(['Profile']);
    }
}

