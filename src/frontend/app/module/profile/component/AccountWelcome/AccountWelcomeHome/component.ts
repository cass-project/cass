import {Component, Injectable} from 'angular2/core';
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../../service/ProfileService";
import {AvatarCropper} from "../../AvatarCropper/index";
import {CORE_DIRECTIVES} from "angular2/common";
import {AuthService} from "../../../../auth/service/AuthService";
import {ProfileNameInfo} from "../../../service/ProfileService";
import {AvatarCropperService} from "../../AvatarCropper/service";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        ProfileService,
        AvatarCropperService
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CORE_DIRECTIVES,
        AvatarCropper
    ]
})


@Injectable()
export class AccountWelcomeHome {
    constructor (private profileService: ProfileService,
                 public router: Router,
                 public avatarCropperService: AvatarCropperService
    ){}

    ngOnInit() {
        if(this.profileService.checkInitProfile()){
            this.router.parent.navigate(['Dashboard']);
        }
    }



    profileNameInfo: ProfileNameInfo = new ProfileNameInfo();

    stageButtons: any = {
        nextShowButton: false
    };

    chooseNameType: any = {
        isVisibleChooseType: true,
        chooseFL: false,
        chooseFLM: false,
        chooseN: false
    };

    showNextStage(){
        this.chooseNameType.isVisibleChooseType = false;
        this.stageButtons.nextShowButton = true;
    }

    showAvatarCropper() {
        this.avatarCropperService.isAvatarFormVisibleFlag = true;
    }

    isAvatarFormVisible() {
        return this.avatarCropperService.isAvatarFormVisibleFlag;
    }

    reset(){
        this.router.parent.navigate(['Dashboard']);
        this.router.parent.navigate(['Welcome']);
    }


    submit(){
                this.router.parent.navigate(['Confirm']);
    }
}
