import {Component} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {ImageCropperComponent, CropperSettings} from 'ng2-img-cropper/src/imageCropper';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService
    ],
    directives: [
        ImageCropperComponent
    ]
})

export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService,
                 public router: Router
    ){
        this.cropperSettings = new CropperSettings();
        this.cropperSettings.width = 100;
        this.cropperSettings.height = 100;
        this.cropperSettings.croppedWidth =100;
        this.cropperSettings.croppedHeight = 100;
        this.cropperSettings.canvasWidth = 400;
        this.cropperSettings.canvasHeight = 300;
        this.data = {};
    }

    cropperSettings: CropperSettings;
    data: any;
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
    AvatarShow: boolean = false;


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