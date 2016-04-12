import {Component, ViewChild, ElementRef} from "angular2/core";

require('./style.head.scss');
declare let Cropper;

@Component({
    template: require('./template.html'),
    styles: [require('./style.shadow.scss')],
    providers:[FileReader]
})

export class TestComponent {

    @ViewChild('cropImage') cropImage:ElementRef;
    private cropper;

    constructor(private fileReader:FileReader) {}

    ngOnInit() : void {
        let testComponent = this;
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

    private destroyCropper() : void {
        if(this.cropper) this.cropper.destroy();
        this.cropper = undefined;
        this.cropImage.nativeElement.src="";
    }

    private getData() : string {
        console.log(this.cropper.getData(true));
        return this.cropper.getData(true);
    }
}