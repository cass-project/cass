import {Injectable} from "@angular/core";
import {Http, Response, ResponseType, ResponseOptions, Headers} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {CommunityCreateRequestModel} from "../model/CommunityCreateRequestModel";
import {CommunityImageUploadRequestModel} from "../model/CommunityImageUploadRequestModel";
import {CommunityControlFeatureRequestModel} from "../model/CommunityActivateFeatureModel";
import {CommunityImageDeleteRequest} from "../definitions/paths/image-delete";
import {EditCommunityRequest, EditCommunityResponse200} from "../definitions/paths/edit";
import {SetPublicOptionsCommunityRequest} from "../definitions/paths/set-public-options";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {CreateCommunityResponse200} from "../definitions/paths/create";
import {GetCommunityResponse200} from "../definitions/paths/get";
import {GetCommunityBySIDResponse200} from "../definitions/paths/get-by-sid";
import {SetPublicOptionsResponse200} from "../../collection/definitions/paths/set-public-optionts";
import {CommunityActivateFeatureResponse200} from "../../community-features/definitions/paths/activate";
import {CommunityDectivateFeatureResponse200} from "../../community-features/definitions/paths/deactivate";

@Injectable()
export class CommunityRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    public create(request: CommunityCreateRequestModel): Observable<CreateCommunityResponse200> {
        let url = "/backend/api/protected/community/create";

        return this.handle(
            this.http.put(url, JSON.stringify(request), {
                headers: this.getAuthHeaders()
            })
        );
    }

    public edit(communityId: number, body: EditCommunityRequest): Observable<EditCommunityResponse200> {
        let url = `/backend/api/protected/community/${communityId}/edit`;

        return this.handle(
            this.http.post(url, JSON.stringify(body), {
                headers: this.getAuthHeaders()
            })
        );
    }

    public getCommunityById(id: string): Observable<GetCommunityResponse200> {
        let url = `/backend/api/community/${id}/get-by-id`;

        return this.handle(
            this.http.get(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    public getCommunityBySid(sid: string): Observable<GetCommunityBySIDResponse200> {
        let url = `/backend/api/community/${sid}/get-by-sid`;

        return this.handle(
            this.http.get(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    public setPublicOptions(communityId: number, body: SetPublicOptionsCommunityRequest): Observable<SetPublicOptionsResponse200> {
        let url = `/backend/api/protected/community/${communityId}/set-public-options`;

        return this.handle(
            this.http.post(url, JSON.stringify(body), {
                headers: this.getAuthHeaders()
            })
        );
    }

    public activateFeature(request: CommunityControlFeatureRequestModel): Observable<CommunityActivateFeatureResponse200> {
        let url = `/backend/api/protected/community/${request.communityId}/feature/${request.feature}/activate`;

        return this.handle(
            this.http.put(url, "{}", {
                headers: this.getAuthHeaders()
            })
        );
    };

    public deactivateFeature(request: CommunityControlFeatureRequestModel): Observable<CommunityDectivateFeatureResponse200> {
        let url = `/backend/api/protected/community/${request.communityId}/feature/${request.feature}/deactivate`;

        return this.handle(
            this.http.delete(url, {
                headers: this.getAuthHeaders()
            })
        );
    };

    public imageUpload(request: CommunityImageUploadRequestModel): Observable<Response> {
        var progressBar: number = 0;

        return Observable.create(observer => {
            let formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", request.uploadImage);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    progressBar = Math.floor((e.loaded / e.total) * 100);
                }
            };

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        observer.next(new Response(new ResponseOptions({
                            body: xhr.response,
                            headers: Headers.fromResponseHeaderString(xhr.getAllResponseHeaders()),
                            status: xhr.status,
                            statusText: xhr.statusText,
                            type: ResponseType.Default
                        })));
                        observer.complete();
                    } else {
                        observer.error(xhr.response);
                    }
                }
            };

            xhr.open("POST", `/backend/api/protected/community/${request.communityId}/image-upload/` +
                `crop-start/${request.x1}/${request.y1}/crop-end/${request.x2}/${request.y2}`);
            xhr.setRequestHeader('Authorization', this.token.apiKey);
            xhr.send(formData);
        });
    }

    public imageDelete(request: CommunityImageDeleteRequest): Observable<Response> {
        let authHeader = new Headers();
        if (this.token.hasToken()) {
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/community/${request.communityId}/image-delete`, {headers: authHeader}));
    }
}
