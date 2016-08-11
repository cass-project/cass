import {Injectable} from "@angular/core";
import {Http, Response, Headers} from "@angular/http";
import {Observable} from "rxjs/Observable";

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {AuthToken} from "../../auth/service/AuthToken";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {CreateCommunityRequest, CreateCommunityResponse200} from "../definitions/paths/create";
import {EditCommunityRequest, EditCommunityResponse200} from "../definitions/paths/edit";
import {GetCommunityResponse200} from "../definitions/paths/get";
import {GetCommunityBySIDResponse200} from "../definitions/paths/get-by-sid";
import {SetPublicOptionsCommunityRequest, SetPublicOptionsCommunityResponse200} from "../definitions/paths/set-public-options";
import {CommunityActivateFeatureResponse200, CommunityActivateFeatureRequest} from "../../community-features/definitions/paths/activate";
import {CommunityDectivateFeatureResponse200, CommunityDeactivateFeatureRequest} from "../../community-features/definitions/paths/deactivate";
import {CommunityImageDeleteRequest, DeleteCommunityImageResponse200} from "../definitions/paths/image-delete";
import {UploadCommunityImageResponse200} from "../definitions/paths/image-upload";

@Injectable()
export class CommunityRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    public create(request: CreateCommunityRequest): Observable<CreateCommunityResponse200> {
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

    public setPublicOptions(communityId: number, body: SetPublicOptionsCommunityRequest): Observable<SetPublicOptionsCommunityResponse200> {
        let url = `/backend/api/protected/community/${communityId}/set-public-options`;

        return this.handle(
            this.http.post(url, JSON.stringify(body), {
                headers: this.getAuthHeaders()
            })
        );
    }

    public activateFeature(request: CommunityActivateFeatureRequest): Observable<CommunityActivateFeatureResponse200> {
        let url = `/backend/api/protected/community/${request.communityId}/feature/${request.feature}/activate`;

        return this.handle(
            this.http.put(url, "{}", {
                headers: this.getAuthHeaders()
            })
        );
    };

    public deactivateFeature(request: CommunityDeactivateFeatureRequest): Observable<CommunityDectivateFeatureResponse200> {
        let url = `/backend/api/protected/community/${request.communityId}/feature/${request.feature}/deactivate`;

        return this.handle(
            this.http.delete(url, {
                headers: this.getAuthHeaders()
            })
        );
    };

    public imageUpload(communityId: number, uploadImage: Blob, x1:number, y1:number, x2:number, y2:number): Observable<UploadCommunityImageResponse200> {
        return Observable.create(observer => {
            let formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", uploadImage);

            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        observer.next(JSON.parse(xhr.response));
                        observer.complete();
                    } else {
                        observer.error(xhr.response);
                    }
                }
            };

            xhr.open("POST", `/backend/api/protected/community/${communityId}/image-upload/` +
                `crop-start/${x1}/${y1}/crop-end/${x2}/${y2}`);
            xhr.setRequestHeader('Authorization', this.token.apiKey);
            xhr.send(formData);
        });
    }

    public imageDelete(request: CommunityImageDeleteRequest): Observable<DeleteCommunityImageResponse200> {
        let url = `/backend/api/protected/community/${request.communityId}/image-delete`;

        return this.handle(
            this.http.delete(url, {
                headers: this.getAuthHeaders()
            })
        );        
    }
}
