import {Injectable} from "angular2/core";

import {UploadImageStrategy, UploadImageCropModel} from "../../form/component/UploadImage/strategy";
import {UploadImageModal} from "../../form/component/UploadImage/index";

export class UploadProfileImageStrategy implements UploadImageStrategy
{
    private xhrRequest: XMLHttpRequest;

    constructor(private profileId: number) {}

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

        let url = `/backend/api/protected/profile/${this.profileId}/image-upload`
            + `/crop-start/${crop.start.x}/${crop.start.y}`
            + `/crop-end/${crop.end.x}/${crop.end.y}`;

        let formData = new FormData();
            formData.append("file", file);

        this.xhrRequest.open("POST", url);
        this.xhrRequest.onprogress = (e) => {
            if (e.lengthComputable) {
                modal.progress.update(Math.floor((e.loaded / e.total) * 100));
            }
        };
        this.xhrRequest.onreadystatechange = () => {
            if (this.xhrRequest.readyState === 4) {
                modal.progress.complete();
            }
        };

        this.xhrRequest.send(formData);
    }
}