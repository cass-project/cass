import {UploadImageStrategy} from "../../util/component/UploadImage/strategy";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {UploadImageModal} from "../../util/component/UploadImage/index";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
        console.log('upload image');

        setTimeout(() => {
            console.log('upload complete');
            modal.close();
        }, 1000)
    }
}