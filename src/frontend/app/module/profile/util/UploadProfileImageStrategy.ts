import {UploadImageStrategy} from "../../util/component/UploadImage/strategy";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {UploadImageModal} from "../../util/component/UploadImage/index";
import {ProfileRESTService} from "../component/ProfileService/ProfileRESTService";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    constructor(private profileRESTService: ProfileRESTService){}


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
        console.log(model);

        this.profileRESTService.avatarUpload(file, model);
        modal.progress.reset();

        while (this.profileRESTService.progressBar !== 100)  {
            console.log(this.profileRESTService.progressBar);
            modal.progress.update(this.profileRESTService.progressBar);
            if(this.profileRESTService.progressBar === 99){
                modal.progress.complete();
                modal.close();
            }
        }
    }
}