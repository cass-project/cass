import {Component, Output, EventEmitter, Input} from "@angular/core";

import {ScreenControls} from "../../../common/classes/ScreenControls";
import {UploadImageService} from "./service";
import {UploadImageCropModel} from "./strategy";
import {ImageCropperService} from "../../../common/component/ImageCropper/index";

enum UploadImageScreen {
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService,
    ],selector: 'cass-upload-image-modal'})

export class UploadImageModal
{
    public progress = new UploadProgress();

    @Input('needToCrop') needToCrop: boolean = true;

    private screen: ScreenControls<UploadImageScreen> = new ScreenControls<UploadImageScreen>(UploadImageScreen.File, (sc: ScreenControls<UploadImageScreen>) => {
        sc.add({ from: UploadImageScreen.File, to: UploadImageScreen.Crop });
        sc.add({ from: UploadImageScreen.Crop, to: UploadImageScreen.Processing });
    });

    @Output('close') closeEvent = new EventEmitter<UploadImageModal>();
    @Output('crop') cropEvent   = new EventEmitter<UploadImageModal>();
    @Output('processing') processingEvent = new EventEmitter<UploadImageModal>();
    @Output('abort') abortEvent = new EventEmitter<UploadImageModal>();
    @Output('complete') complete = new EventEmitter<any>();

    constructor(
        public cropper: ImageCropperService,
        public service: UploadImageService
    ) {}

    private onFileChange($event) : void {
        if(this.needToCrop){
            this.cropper.setFile($event.target.files[0]);
            this.screen.goto(UploadImageScreen.Crop);
            this.cropEvent.emit(this);
        } else {
            this.service.process($event.target.files[0], this);
            this.complete.emit($event.target.files[0]);
        }
    }

    process() {
        let model: UploadImageCropModel = {
            x: this.cropper.getX(),
            y: this.cropper.getY(),
            width: this.cropper.getWidth(),
            height: this.cropper.getHeight()
        };

        this.processingEvent.emit(this);

        this.service.process(this.cropper.getFile(), this, model);
        this.screen.goto(UploadImageScreen.Processing);
    }

    abort() {
        this.service.abort(this.cropper.getFile(), this);
        this.abortEvent.emit(this);
        this.screen.goto(UploadImageScreen.File);
    }

    close() {
        this.closeEvent.emit(this);
    }
}

class UploadProgress
{
    public value: number = 0;

    public reset() {
        this.value = 0;
    }

    abort() {
        this.value = 0;
    }

    complete() {
        this.value = 100;
    }

    update(value: number) {
        if(value < 0 || value > 100) {
            throw new Error(`Invalid progress ${value}`);
        }

        this.value = value;
    }
}