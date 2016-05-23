import {Component} from "angular2/core";
import {Output} from "angular2/core";
import {EventEmitter} from "angular2/core";

import {ModalComponent} from "../../../modal/component/index";
import {ImageCropperService} from "../../../util/component/ImageCropper/index";
import {ImageCropper} from "../../../util/component/ImageCropper/index";
import {ScreenControls} from "../../../util/classes/ScreenControls";

enum UploadImageScreen {
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-upload-image-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    providers: [
        ImageCropperService,
    ],
    directives: [
        ModalComponent,
        ImageCropper,
    ]
})
export class ProfileUploadImageModal
{
    private file: DataTransfer;
    private filePath: string;

    private screen: ScreenControls<UploadImageScreen> = new ScreenControls<UploadImageScreen>(UploadImageScreen.File, (sc: ScreenControls<UploadImageScreen>) => {
        sc.add({ from: UploadImageScreen.File, to: UploadImageScreen.Crop });
        sc.add({ from: UploadImageScreen.Crop, to: UploadImageScreen.Processing });
    });

    @Output('close') closeEvent = new EventEmitter<ProfileUploadImageModal>();
    @Output('crop') cropEvent   = new EventEmitter<ProfileUploadImageModal>();
    @Output('before-processing') beforeProcessing = new EventEmitter<ProfileUploadImageModal>();
    @Output('after-processing') afterProcessing = new EventEmitter<ProfileUploadImageModal>();
    @Output('complete') complete = new EventEmitter<ProfileUploadImageModal>();

    constructor(public service: ImageCropperService) {
        service.options = {
            aspectRatio: 1 /* 1/1 */,
            viewMode: 2 /* VM3 */,
            background: false,
            center: true,
            highlight: false,
            guides: false,
            movable: true,
            minCropBoxWidth: 150,
            minCropBoxHeight: 150,
            rotatable: false,
            scalable: false,
            toggleDragModeOnDblclick: false,
            zoomable: true,
            minContainerWidth: 500,
            minContainerHeight: 500
        };
    }

    private onFileChange($event) : void {
        this.service.setFile($event.target.files[0]);
        this.screen.goto(UploadImageScreen.Crop);
        this.cropEvent.emit(this);
    }

    process() {
        let model = {
            x: this.service.getX(),
            y: this.service.getY(),
            width: this.service.getWidth(),
            height: this.service.getHeight()
        };

        this.beforeProcessing.emit(this);
        this.afterProcessing.emit(this);

        // Upload.

        this.screen.goto(UploadImageScreen.Processing);
    }

    close() {
        this.closeEvent.emit(this);
    }
}