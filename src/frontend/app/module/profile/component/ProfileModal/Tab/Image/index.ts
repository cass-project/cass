import {Component} from "angular2/core";

import {ProfileImage} from "../../../ProfileImage/index";

enum ImageTabStage {
    View = <any>"View",
    File = <any>"File",
    Crop = <any>"Crop",
    Processing = <any>"Processing"
}

@Component({
    selector: 'cass-profile-modal-tab-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ProfileImage
    ]
})
export class ImageTab
{
    stage: ImageTabCurrentStage = new ImageTabCurrentStage();

    uploadProfileImage() {
        this.stage.go(ImageTabStage.File);
    }

    cropProfileImage() {
        this.stage.go(ImageTabStage.Crop);
    }

    processUploadProfileImage() {
        this.stage.go(ImageTabStage.Processing);
    }
}

class ImageTabCurrentStage
{
    static DEFAULT_STAGE = ImageTabStage.View;

    public current: ImageTabStage = ImageTabCurrentStage.DEFAULT_STAGE;

    go(tab: ImageTabStage) {
        this.current = tab;
    }

    isOn(tab: ImageTabStage) {
        return this.current === tab;
    }
}