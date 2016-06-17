import {Injectable} from "angular2/core";
import {Http, Response, ResponseType, ResponseOptions, Headers} from "angular2/http";
import {Observable} from "rxjs/Observable";
import {getResponseURL} from "angular2/src/http/http_utils";

import {UploadImageCropModel} from "../../util/component/UploadImage/strategy";
import {CommunityCreateRequestModel} from "../model/CommunityCreateRequestModel";
import {CommunityImageUploadRequestModel} from "../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../model/CommunityActivateFeatureModel";

@Injectable()
export class CommunityRESTService
{
    constructor(private http:Http) {}

    public create(request:CommunityCreateRequestModel)
    {
        return this.http.put("/backend/api/protected/community/create", JSON.stringify(request));
    }

    public getBySid(sid:string)
    {
        return this.http.get(`/backend/api/community/${sid}/get-by-sid`);
    }

    public progressBar:number;

    public imageUpload(request:CommunityImageUploadRequestModel)
    {

        return Observable.create(observer => {
            let formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", request.uploadImage);

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

            xhr.open("POST", `/backend/api/protected/community/${request.communityId}/image-upload/`+
                             `crop-start/${request.x1}/${request.y1}/crop-end/${request.x2}/${request.y2}`);
            xhr.send(formData);
        });
    }

    public activateFeature(reqeust: CommunityControlFeatureRequestModel) : Observable<Response>
    {
        return this.http.put(`/backend/api/protected/community/${reqeust.communityId}/feature/${reqeust.feature}/activate`, "{}");
    };

    public deactivateFeature(reqeust: CommunityControlFeatureRequestModel)
    {
        return this.http.delete(`/backend/api/protected/community/${reqeust.communityId}/feature/${reqeust.feature}/deactivate`);
    };
}
