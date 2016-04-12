import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {AvatarCropper} from "../ProfileEdit/AvatarCropper/AvatarCropper";
import {PreInfo} from "./PreInfo/component";




@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    directives: [
        ROUTER_DIRECTIVES
    ],
    'providers': [
        CurrentProfileRestService,
        PreInfo
    ]
})

export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService,
                 public router: Router,
                 public preInfo: PreInfo
    ){}

    chooseType: boolean = true;
    chooseFL: boolean = false;
    chooseLFM: boolean = false;
    chooseN: boolean = false;

    NextShow: boolean = false;
    SubmitShow: boolean = false;
    AvatarCropper: boolean = false;
    preInfo: boolean = false;


    reset(){
        this.router.parent.navigate(['Profile']);
        this.router.parent.navigate(['Welcome']);
    }
}