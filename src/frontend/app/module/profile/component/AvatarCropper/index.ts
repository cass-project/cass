declare var Cropper;

import {Component, ViewChild, ElementRef, Injectable} from "angular2/core";
import {Router, RouteConfig, ROUTER_DIRECTIVES} from 'angular2/router';
import {ProfileService} from "../../service/ProfileService";
import {AvatarCropperService} from "./service";
import {AuthService} from "../../../auth/service/AuthService";
import {AccountConfirm} from "../AccountWelcome/Confirm/component";

require('./style.head.scss');

@Component({
    template: require('./template.html'),
    styles: [require('./style.shadow.scss')],
    providers: [
        FileReader
    ],
    selector: 'avatar-cropper',
    directives: [
        ROUTER_DIRECTIVES
    ]
})

@Injectable()
export class AvatarCropper {
    constructor(private fileReader: FileReader,
                public profileService: ProfileService,
                public avatarCropperService: AvatarCropperService,
                public router: Router
    ){}

    @ViewChild('cropImage') cropImage:ElementRef;
    public cropper;
    private file: Blob;

    ngOnInit(): void {
        this.fileReader = new FileReader();
        this.fileReader.onload = () => {
            this.initCropper();
        };
    }

    private onFileChange(event) : void {
        this.file = event.target.files[0];
        this.fileReader.readAsDataURL(this.file);
    }

    private initCropper() : void {
        this.cropImage.nativeElement.src = this.fileReader.result;
        if (this.cropper) this.cropper.destroy();

        /**
         * @see https://www.npmjs.com/package/cropperjs
         * @see http://fengyuanchen.github.io/cropperjs/
         */
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
        let coord = this.getData();
        this.profileService.avatarUpload(this.file, {
            start: {
                x: coord.x,
                y: coord.y
            },
            end: {
                x: coord.x + coord.width,
                y: coord.y + coord.height
            }
        });
    }

    private getData() {
        return this.cropper.getData(true);
    }
}