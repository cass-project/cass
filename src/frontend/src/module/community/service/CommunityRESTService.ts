import {Injectable} from "angular2/core";
import {Http, Response, ResponseType, ResponseOptions, Headers} from "angular2/http";
import {Observable} from "rxjs/Observable";
import {getResponseURL} from "angular2/src/http/http_utils";

import {CommunityCreateRequestModel} from "../model/CommunityCreateRequestModel";
import {CommunityImageUploadRequestModel} from "../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../model/CommunityActivateFeatureModel";
import {CommunityImageDeleteRequest} from "../definitions/paths/image-delete";
import {EditCommunityRequest} from "../definitions/paths/edit";
import {SetPublicOptionsCommunityRequest} from "../definitions/paths/set-public-options";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class CommunityRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) {super(http, token, messages);}

    public create(request: CommunityCreateRequestModel): Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put("/backend/api/protected/community/create", JSON.stringify(request), {headers: authHeader}));
    }

    public edit(communityId:number, body: EditCommunityRequest): Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/community/${communityId}/edit`, JSON.stringify(body), {headers: authHeader}));
    }

    public getCommunityBySid(sid:string)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/community/${sid}/get-by-sid`, {headers: authHeader}));
    }

    public setPublicOptions(communityId:number, body: SetPublicOptionsCommunityRequest): Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/community/${communityId}/set-public-options`, JSON.stringify(body), {headers: authHeader}));
    }

    public progressBar:number;

    public imageUpload(request:CommunityImageUploadRequestModel): Observable<Response>
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
            xhr.setRequestHeader('Authorization', this.token.apiKey);
            xhr.send(formData);
        });
    }

    public imageDelete(request:CommunityImageDeleteRequest): Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/community/${request.communityId}/image-delete`, {headers: authHeader}));
    }

    public activateFeature(reqeust: CommunityControlFeatureRequestModel) : Observable<Response>
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.http.put(`/backend/api/protected/community/${reqeust.communityId}/feature/${reqeust.feature}/activate`, "{}", {headers: authHeader});
    };

    public deactivateFeature(reqeust: CommunityControlFeatureRequestModel)
    {
        let authHeader = new Headers();
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.http.delete(`/backend/api/protected/community/${reqeust.communityId}/feature/${reqeust.feature}/deactivate`, {headers: authHeader});
    };
}
