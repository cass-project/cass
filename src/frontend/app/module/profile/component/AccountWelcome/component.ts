import {Component, Injectable} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {AvatarCropper} from "./AvatarCropper/index";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService,
    ],
    directives: [
        ROUTER_DIRECTIVES,
        AvatarCropper
    ]
})

@Injectable()
export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService,
                 public router: Router
    ){}

    avatarCropper: AvatarCropper;

    avatar: any;
    profileId: number;
    nickname: string;
    firstname: string;
    lastname: string;
    middlename: string;

    chooseType: boolean = true;
    chooseFL: boolean = false;
    chooseLFM: boolean = false;
    chooseN: boolean = false;

    NextShow: boolean = false;
    SubmitShow: boolean = false;
    PreInfo: boolean = false;
    ChangeAvatar: boolean = false;

    reset(){
        this.router.parent.navigate(['Profile']);
        this.router.parent.navigate(['Welcome']);
    }

    sumbit(){
        let xS;
        let yS;
        let xE;
        let yE;

        if(this.chooseFL){
            this.currentProfileRestService.greetingsAsFL(this.profileId, this.firstname, this.lastname).subscribe(data => {
                this.currentProfileRestService.avatarUpload(this.profileId, xS, yS, xE, yE).subscribe(data => {
                    this.router.parent.navigate(['Collection'])
                });
            });
        }
    }

}