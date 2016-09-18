import {Observable} from "rxjs/Rx";

import {UploadImageStrategy, UploadImageCropModel} from "../../common/component/UploadImage/strategy";
import {UploadImageModal} from "../../common/component/UploadImage/index";
import {UploadProfileImageResponse200, UploadProfileImageProgress} from "../definitions/paths/image-upload";
import {ProfileRESTService} from "../service/ProfileRESTService";
import {ProfileEntity} from "../definitions/entity/Profile";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    private observable: Observable<UploadProfileImageProgress|UploadProfileImageResponse200>;
    private last: UploadProfileImageResponse200;

    constructor(
        private profile: ProfileEntity,
        private service: ProfileRESTService
    ) {}

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
        modal.progress.abort();
    }

    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
        this.observable = this.service.imageUpload(this.profile.id, {
            file: file,
            crop: {
                x1: model.x,
                y1: model.y,
                x2: model.width + model.x,
                y2: model.height + model.y,
            }
        });

        this.observable.subscribe(
            (response) => {
                if(response['progress']) {
                    modal.progress.update(response['progress']);
                }

                this.last = <UploadProfileImageResponse200>response;
            },
            (error) => {
                modal.abort();
            },
            () => {
                this.profile.image = this.last.image;

                modal.progress.complete();
                modal.close();
            }
        );

        modal.progress.reset();
    }
}