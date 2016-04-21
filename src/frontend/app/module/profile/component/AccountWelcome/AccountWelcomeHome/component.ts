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
        if(this.chooseNameType.chooseFL) {
            this.profileService.greetingsAsFL(this.profileNameInfo.firstname, this.profileNameInfo.lastname).subscribe(data => {
                this.router.parent.navigate(['Confirm']);
                AuthService.getAuthToken().getCurrentProfile().entity.greetings.greetings_method = 'fl';
            });
        } else if(this.chooseNameType.chooseFLM) {
            this.profileService.greetingsAsFLM(this.profileNameInfo.firstname, this.profileNameInfo.lastname, this.profileNameInfo.middlename).subscribe(data => {
                this.router.parent.navigate(['Confirm']);
            });
        } else if(this.chooseNameType.chooseN){
            this.profileService.greetingsAsN(this.profileNameInfo.nickname).subscribe(data => {
                this.router.parent.navigate(['Confirm']);
            });
        }
    }
}

