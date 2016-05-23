declare var Cropper;

import {Component, ViewChild, ElementRef, Injectable} from "angular2/core";
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {AvatarCropperService} from "./service";
import {AuthService} from "../../../auth/service/AuthService";
import {ProfileRESTService} from "../../../profile/component/ProfileService/ProfileRESTService";

require('./style.head.scss');

@Component({
    template: require('./template.html'),
    styles: [require('./style.shadow.scss')],
    providers: [
        FileReader,
        ProfileRESTService
    ],
    selector: 'avatar-cropper',
    directives: [
        ROUTER_DIRECTIVES
    ]
})

@Injectable()
/** @deprecated */
export class AvatarCropper {
    constructor(private fileReader: FileReader,
                public avatarCropperService: AvatarCropperService,
                public profileRESTService: ProfileRESTService,
                public router: Router
    ){}

    @ViewChild('cropImage') cropImage:ElementRef;

    public showProgressBar = false;
    public cropper;


    ngOnInit() {
        this.fileReader = new FileReader();
        this.fileReader.onload = () => {
            this.initCropper();
        };
        this.fileReader.readAsDataURL(this.avatarCropperService.file);
        this.avatarCropperService.imgPath = URL.createObjectURL(this.avatarCropperService.file);
    }

    private initCropper() : void {
        this.cropImage.nativeElement.src = this.fileReader.result;
        if (this.cropper) this.cropper.destroy();

        this.cropper = new Cropper(this.cropImage.nativeElement, {
            aspectRatio : 1 /* 1/1 */,
            viewMode    : 3 /* VM3 */,
            background  : false,
            center      : false,
            highlight   : false,
            guides      : false,
            movable     : false,
            minCropBoxWidth : 150,
            minCropBoxHeight: 150,
            rotatable   : false,
            scalable    : false,
            toggleDragModeOnDblclick : false,
            zoomable    : false
        });
    }

    private close(){
        this.avatarCropperService.isAvatarFormVisibleFlag = false;
        this.destroyCropper();
    }
    private destroyCropper() : void {
        if(this.cropper) this.cropper.destroy();
        this.cropper = undefined;
        this.cropImage.nativeElement.src="";
    }

    private submit(){
        this.showProgressBar = true;
        let crop = {
            start: {
                x: this.cropper.getData(true).x,
                y: this.cropper.getData(true).y
            },
            end: {
                x: this.cropper.getData(true).x + this.cropper.getData(true).width,
                y: this.cropper.getData(true).y + this.cropper.getData(true).height
            }
        };
        this.avatarCropperService.crop = crop;
        if(this.avatarCropperService.profileAvatar){
            this.profileRESTService.avatarUpload();
        }
    }

    /*private getPreviewImageData(data: string){
        let coord = this.getData();
        let avatarSize = 300;
        let scaleX = avatarSize / (coord.width);
        let scaleY = avatarSize / (coord.height);

        let parentWidth = this.getImageData().width;
        let parentHeight = this.getImageData().height;

        switch (data) {
        case 'x1':
            return -Math.round(scaleX * coord.x);
            break;
        case 'y1':
            return -Math.round(scaleY * coord.y);
            break;
        case 'width':
            return Math.round(parentWidth * scaleX);
            break;
        case 'height':
            return Math.round(parentHeight * scaleY);
            break;
        }
    }

    private getImageData(){
        return this.cropper.getImageData(true);
    }*/


}
