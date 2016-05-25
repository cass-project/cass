import {Component, Injectable} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
import {ImageCropperService} from "../../../../../util/component/ImageCropper/index";
import {UploadImageService} from "../../../../../util/component/UploadImage/service";
import {ImageCropper} from "../../../../../util/component/ImageCropper/index";
import {ScreenControls} from "../../../../../util/classes/ScreenControls";
import {UploadImageCropModel} from "../../../../../util/component/UploadImage/strategy";

enum UploadImageScreen {
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-setup-screen-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService
    ],
    directives: [
        CORE_DIRECTIVES,
        ImageCropper,
    ]
})


@Injectable()
export class ProfileSetupScreenImage
{
    public progress = new UploadProgress();

    private screen: ScreenControls<UploadImageScreen> = new ScreenControls<UploadImageScreen>(UploadImageScreen.File, (sc: ScreenControls<UploadImageScreen>) => {
        sc.add({ from: UploadImageScreen.File, to: UploadImageScreen.Crop });
        sc.add({ from: UploadImageScreen.Crop, to: UploadImageScreen.Processing });
    });

    constructor(
        public cropper: ImageCropperService) {}

    private onFileChange($event) : void {
        this.cropper.setFile($event.target.files[0]);
        this.screen.goto(UploadImageScreen.Crop);
    }

    process() {
        let model: UploadImageCropModel = {
            x: this.cropper.getX(),
            y: this.cropper.getY(),
            width: this.cropper.getWidth(),
            height: this.cropper.getHeight()
        };

        console.log(model);
        this.screen.goto(UploadImageScreen.Processing);
    }

    abort() {
        this.screen.goto(UploadImageScreen.Crop); //ToDo: Надо будет потом написать нормальный метод обрыва закачки.
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