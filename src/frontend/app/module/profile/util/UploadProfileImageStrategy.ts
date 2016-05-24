import {UploadImageStrategy} from "../../util/component/UploadImage/strategy";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {UploadImageModal} from "../../util/component/UploadImage/index";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    getCropperOptions() {
        return {
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

    abort(file: Blob, modal: UploadImageModal) {
        console.log('upload aborted');
        modal.progress.abort();
    }

    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
        console.log('upload image');

        modal.progress.reset();

        setTimeout(() => {
            modal.progress.update(50);

            setTimeout(() => {
                console.log('upload complete');
                modal.progress.complete();
                modal.close();
            }, 1000);
        }, 1000);
    }
}