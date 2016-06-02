import {Injectable} from "angular2/core";
import {Http} from 'angular2/http';
import {CommunityCreateModalModel} from "../component/Modal/CommunityCreateModal/model";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {Observable} from "rxjs/Observable";

@Injectable()
export class CommunityRESTService
{
    constructor(private http:Http) {}

    public create(title: string, description: string, theme_id: number) {
        let data = {
            "title"       : title,
            "description" : description,
            "theme_id"    : theme_id
        };
        return this.http.put("/backend/api/protected/community/create", JSON.stringify(data));
    }

    public progressBar:number;

    public imageUpload(communityId:number, uploadImage: Blob, uploadImageCrop: UploadImageCropModel) {
        return new Promise(function (resolve, reject) {
            let x1 = uploadImageCrop.x,
                y1 = uploadImageCrop.y,
                x2 = uploadImageCrop.width + uploadImageCrop.x,
                y2 = uploadImageCrop.height + uploadImageCrop.y;

            let formData:FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", uploadImage);
            xhr.open("POST", `/backend/api/protected/community/${communityId}/image-upload/crop-start/${x1}/${y1}/crop-end/${x2}/${y2}`);

            xhr.onload = function () {
                if (this.status >= 200 && this.status < 300) {
                    resolve(xhr.response);
                } else {
                    reject({
                        status: this.status,
                        statusText: xhr.statusText
                    });
                }
            };

            xhr.onerror = function () {
                reject({
                    status: this.status,
                    statusText: xhr.statusText
                });
            };

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    this.progressBar = Math.floor((e.loaded / e.total) * 100);
                    console.log(this.progressBar);
                }
            };

            xhr.send(formData);
        })
    }

    public activateFeature(communityId: number, feature:string) {
        return this.http.put(`/backend/api/protected/community/${communityId}/feature/${feature}/activate`, "{}");
    };

    public deactivateFeature(communityId: number, feature:string) {
        return this.http.delete(`/backend/api/protected/community/${communityId}/feature/${feature}/deactivate`);
    };
}
