import {Component, ViewChild, ElementRef, Injectable} from "angular2/core";
import {AvatarCropperService} from "../../../service/AvatarCropperService";
import {CurrentProfileRestService} from "../../../service/CurrentProfileRestService";

require('./style.head.scss');
declare let Cropper;

@Component({
    template: require('./template.html'),
    styles: [require('./style.shadow.scss')],
    providers:[FileReader],
    selector: 'avatar-cropper'
})

@Injectable()
export class AvatarCropper {

    constructor(private fileReader:FileReader,
                public avatarCropperService: AvatarCropperService,
                public currentProfileRestService: CurrentProfileRestService
    ){}



    @ViewChild('cropImage') cropImage:ElementRef;
    private cropper;


    ngOnInit() : void {
        let testComponent = this;
        this.fileReader = new FileReader();
        this.fileReader.onload = function() {
            testComponent.initCropper();
        }
    }

    private onFileUploaded(event) : void {
        this.fileReader.readAsDataURL(event.srcElement.files[0]);
    }

    private initCropper() : void {
        this.cropImage.nativeElement.src = this.fileReader.result;
        if (this.cropper) this.cropper.destroy();
        this.cropper = new Cropper(this.cropImage.nativeElement, {
            aspectRatio : 1/1,
            viewMode    : 3,
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
            // Lookup: https://www.npmjs.com/package/cropperjs
        });
    }

    private close(){
        this.avatarCropperService.isAvatarFormVisible = false;
        this.destroyCropper();
    }

    private destroyCropper() : void {
        if(this.cropper) this.cropper.destroy();
        this.cropper = undefined;
        this.cropImage.nativeElement.src="";
    }

    private submit(){
        let coord = this.getData();
        this.currentProfileRestService.avatarUpload("1", coord.x, coord.y, (coord.x + coord.width), (coord.y + coord.height)).subscribe(data => {console.log("work")}, err => {console.log("not work")})
    }

    private getData() {
        console.log(this.cropper.getData(true));
        return this.cropper.getData(true);
    }
}