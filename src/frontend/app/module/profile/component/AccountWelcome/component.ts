import {Component, ViewChild, ElementRef} from 'angular2/core';
import {RouteConfig, ROUTER_DIRECTIVES, Router} from 'angular2/router';
import {CurrentProfileRestService} from "../../service/CurrentProfileRestService";
import {ImageCropper} from "../../../../../node_modules/ng2-img-cropper/src/imageCropper";

declare var Cropper;

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss'),
    ],
    'providers': [
        CurrentProfileRestService
    ]
})

export class AccountWelcome {
    constructor (private currentProfileRestService: CurrentProfileRestService,
                 public router: Router
    ){}

    @ViewChild('cropcanvas') cropcanvas: ElementRef;
    private cropper: ImageCropper;

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

    //ngOnInit() {
    //    let cropper = new Cropper(this.image, {
    //        aspectRatio: 16 / 9,
    //        crop: function(e) {
    //            console.log(e.detail.x);
    //            console.log(e.detail.y);
    //            console.log(e.detail.width);
    //            console.log(e.detail.height);
    //            console.log(e.detail.rotate);
    //            console.log(e.detail.scaleX);
    //            console.log(e.detail.scaleY);
    //        }
    //    })
    //}

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