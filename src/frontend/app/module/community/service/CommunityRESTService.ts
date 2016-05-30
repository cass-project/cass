import {Injectable} from "angular2/core";
import {Http} from 'angular2/http';
import {CommunityCreateModalModel} from "../component/Modal/CommunityCreateModal/model";
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {Observable} from "rxjs/Observable";

@Injectable()
export class CommunityRESTService
{
    constructor(private http:Http) {}

    public create(model: CommunityCreateModalModel) {
        return this.http.put("/backend/api/protected/community/create", JSON.stringify({
            "title": model.title,
            "description": model.description,
            "theme_id": model.theme_id
        }))
    }

    public progressBar:number;

    public imageUpload(communityId:number, uploadImage: Blob, uploadImageCrop: UploadImageCropModel, callback: Function){
        let x1 = uploadImageCrop.x,
            y1 = uploadImageCrop.y,
            x2 = uploadImageCrop.width + uploadImageCrop.x,
            y2 = uploadImageCrop.height + uploadImageCrop.y;

        let formData:FormData = new FormData(),
            xhr: XMLHttpRequest = new XMLHttpRequest();

        formData.append("file", uploadImage);

        xhr.open("POST", `/backend/api/protected/community/${communityId}/image-upload/crop-start/${x1}/${y1}/crop-end/${x2}/${y2}`);

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                this.progressBar = Math.floor((e.loaded / e.total) * 100);
                console.log(this.progressBar);
            }
        };

        xhr.send(formData);

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    callback();
                } else {
                    throw new Error('Fail to upload image.');
                }
            }
        }
    }
}
