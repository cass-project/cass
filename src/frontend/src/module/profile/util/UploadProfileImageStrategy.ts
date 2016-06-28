import {Injectable} from "angular2/core";

import {UploadImageStrategy, UploadImageCropModel} from "../../form/component/UploadImage/strategy";
import {UploadImageModal} from "../../form/component/UploadImage/index";
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class UploadProfileImageStrategy implements UploadImageStrategy
{
    private xhrRequest: XMLHttpRequest;

    constructor(private authService: AuthService) {}

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
        if(this.xhrRequest) {
            this.xhrRequest.abort();
        }

        modal.progress.abort();
    }

    process(file: Blob, model: UploadImageCropModel, modal: UploadImageModal) {
        this.avatarUpload(file, model, modal);
        modal.progress.reset();
    }

    avatarUpload(file, model, modal) {
        this.xhrRequest = new XMLHttpRequest();

        let xhrRequest = this.xhrRequest;

        var tryNumber = 0;
        var progressBar = 0;

        let crop = {
            start: {
                x: model.x,
                y: model.y
            },
            end: {
                x: model.width + model.x,
                y: model.height + model.y
            }
        };

        tryNumber++;
        let url = `/backend/api/protected/profile/${this.authService.getAuthToken().getCurrentProfile().entity.profile.id}/image-upload/crop-start/${crop.start.x}/${crop.start.y}/crop-end/${crop.end.x}/${crop.end.y}`;
        let formData = new FormData();
        formData.append("file", file);

        xhrRequest.open("POST", url);
        xhrRequest.onprogress = (e) => {
            if (e.lengthComputable) {
                progressBar = Math.floor((e.loaded / e.total) * 100);
                modal.progress.update(progressBar);
            }
        };

        xhrRequest.send(formData);

        xhrRequest.onreadystatechange = () => {
            if (xhrRequest.readyState === 4) {
                if (xhrRequest.status === 200) {
                    this.authService.getAuthToken().getCurrentProfile().entity.profile.image = JSON.parse(xhrRequest.responseText).image;
                }
                modal.progress.complete();
                if(modal.close){
                    modal.close();
                } else {
                    modal.screen.next();
                }

                progressBar = 0;
                tryNumber = 0;
            }
        }
    }
}