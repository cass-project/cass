import {Component} from "angular2/core";
import {Output, Input} from "angular2/core";
import {EventEmitter} from "angular2/core";
import {ModalComponent} from "../../../modal/component/index";
import {ScreenControls} from "../../../common/classes/ScreenControls";
import {UploadImageService} from "./service";
import {UploadImageCropModel} from "./strategy";
import {ModalBoxComponent} from "../../../modal/component/box/index";
import {ImageCropperService, ImageCropper} from "../../../form/component/ImageCropper/index";

enum UploadImageScreen {
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-upload-image-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService,
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
        ImageCropper,
    ]
})
export class UploadImageModal
{
    public progress = new UploadProgress();

    private screen: ScreenControls<UploadImageScreen> = new ScreenControls<UploadImageScreen>(UploadImageScreen.File, (sc: ScreenControls<UploadImageScreen>) => {
        sc.add({ from: UploadImageScreen.File, to: UploadImageScreen.Crop });
        sc.add({ from: UploadImageScreen.Crop, to: UploadImageScreen.Processing });
    });

    @Output('close') closeEvent = new EventEmitter<UploadImageModal>();
    @Output('crop') cropEvent   = new EventEmitter<UploadImageModal>();
    @Output('processing') processingEvent = new EventEmitter<UploadImageModal>();
    @Output('abort') abortEvent = new EventEmitter<UploadImageModal>();

    constructor(
        public cropper: ImageCropperService,
        public service: UploadImageService
    ) {}

    private onFileChange($event) : void {
        this.cropper.setFile($event.target.files[0]);
        this.screen.goto(UploadImageScreen.Crop);
        this.cropEvent.emit(this);
    }

    process() {
        let model: UploadImageCropModel = {
            x: this.cropper.getX(),
            y: this.cropper.getY(),
            width: this.cropper.getWidth(),
            height: this.cropper.getHeight()
        };

        this.processingEvent.emit(this);

        this.service.process(this.cropper.getFile(), model, this);
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