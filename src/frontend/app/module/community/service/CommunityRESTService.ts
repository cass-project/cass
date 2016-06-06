import {Injectable} from "angular2/core";
import {Http} from 'angular2/http';
import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {Observable} from "rxjs/Observable";
import {Response} from "angular2/http";
import {ResponseOptions} from "angular2/http";
import {ResponseType} from "angular2/http";
import {Headers} from "angular2/http";
import {getResponseURL} from "angular2/src/http/http_utils";

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

    public imageUpload(communityId:number, uploadImage: Blob, uploadImageCrop: UploadImageCropModel) : Observable<Response> {
        return Observable.create(observer => {
            let x1 = uploadImageCrop.x,
                y1 = uploadImageCrop.y,
                x2 = uploadImageCrop.width + uploadImageCrop.x,
                y2 = uploadImageCrop.height + uploadImageCrop.y,
                formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", uploadImage);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    this.progressBar = Math.floor((e.loaded / e.total) * 100);
                }
            };

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        observer.next(new Response(new ResponseOptions({
                            body        : xhr.response,
                            headers     : Headers.fromResponseHeaderString(xhr.getAllResponseHeaders()),
                            status      : xhr.status,
                            statusText  : xhr.statusText,
                            type        : ResponseType.Default,
                            url         : getResponseURL(xhr)
                        })));
                        observer.complete();
                    } else {
                        observer.error(xhr.response);
                    }
                }
            };
            xhr.open("POST", `/backend/api/protected/community/${communityId}/image-upload/crop-start/${x1}/${y1}/crop-end/${x2}/${y2}`);

            xhr.send(formData);
        });
    }

    public activateFeature(communityId: number, feature:string) : Observable<Response> {
        return this.http.put(`/backend/api/protected/community/${communityId}/feature/${feature}/activate`, "{}");
    };

    public deactivateFeature(communityId: number, feature:string) {
        return this.http.delete(`/backend/api/protected/community/${communityId}/feature/${feature}/deactivate`);
    };
}
