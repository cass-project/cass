declare var Cropper;

import {Injectable} from "angular2/core";
import {Component} from "angular2/core";
import {ViewChild} from "angular2/core";
import {ElementRef} from "angular2/core";

@Injectable()
export class ImageCropperService
{
    public cropper;
    public file: Blob;

    public options: any = {
        aspectRatio : 1 /* 1/1 */,
        viewMode    : 3 /* VM3 */,
    };

    public hasCropper() {
        return this.cropper !== undefined;
    }

    public setFile(file: Blob) {
        this.file = file;
    }

    public reset() {
        this.file = undefined;
    }

    public getFile() {
        if(this.file) {
            return this.file;
        }else{
            throw new Error('No file available');
        }
    }

    public getData() {
        if(this.cropper) {
            return this.cropper.getData(true);
        }else{
            throw new Error('No cropper available');
        }
    }

    public getX(): number {
        return this.getData().x;
    }

    public getY(): number {
        return this.getData().y;
    }

    public getWidth(): number {
        return this.getData().width;
    }

    public getHeight(): number {
        return this.getData().height;
    }
}

@Component({
    selector: 'cass-image-cropper',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ImageCropper
{
    private fileReader: FileReader;

    @ViewChild('cropImage') cropImage: ElementRef;

    constructor(private service: ImageCropperService) {}

    ngOnInit() {
        this.fileReader = new FileReader();
        this.fileReader.onload = () => {
            this.initCropperJS();
        };

        this.fileReader.readAsDataURL(this.service.getFile());
    }

    ngOnDestroy() {
        if(this.service.cropper) {
            this.destroyCropperJS();
        }
    }

    private initCropperJS() {
        this.cropImage.nativeElement.src = this.fileReader.result;

        if (this.service.cropper) {
            this.destroyCropperJS();
        }

        this.service.cropper = new Cropper(this.cropImage.nativeElement, this.service.options);
    }

    private destroyCropperJS() {
        this.service.cropper.destroy();
        this.service.cropper = undefined;
    }
}