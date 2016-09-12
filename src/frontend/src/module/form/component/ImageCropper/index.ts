declare var Cropper;

import {Injectable, Output, EventEmitter, OnDestroy, OnInit, Directive} from "@angular/core";
import {Component} from "@angular/core";
import {ViewChild} from "@angular/core";
import {ElementRef} from "@angular/core";

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

    public getFile(): Blob {
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
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-image-cropper'})

export class ImageCropper implements OnInit, OnDestroy
{
    private fileReader: FileReader;

    @ViewChild('cropImage') cropImage: ElementRef;
    @Output("cropInit") cropInit = new EventEmitter<ImageCropper>();
    @Output("cropStart") cropStart = new EventEmitter<ImageCropper>();
    @Output("cropEnd") cropEnd = new EventEmitter<ImageCropper>();
    @Output("cropMove") cropMove = new EventEmitter<ImageCropper>();

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

        this.cropImage.nativeElement.addEventListener('cropstart', ()=> {this.cropStart.emit(this); });
        this.cropImage.nativeElement.addEventListener('cropend', ()=> {this.cropEnd.emit(this); });
        this.cropImage.nativeElement.addEventListener('cropmove', ()=> {this.cropMove.emit(this); });

        if (this.service.cropper) {
            this.destroyCropperJS();
        }

        this.service.cropper = new Cropper(this.cropImage.nativeElement, this.service.options);
        this.cropInit.emit(this);
    }

    private destroyCropperJS() {
        this.service.cropper.destroy();
        this.service.cropper = undefined;
    }
}