import {Injectable} from "@angular/core";
import {Http, Response, ResponseType, ResponseOptions, Headers} from "@angular/http";
import {Observable} from "rxjs/Observable";

import {CommunityImageDeleteRequest, DeleteCommunityImageResponse200} from "../definitions/paths/image-delete";
import {EditCommunityRequest, EditCommunityResponse200} from "../definitions/paths/edit";
import {SetPublicOptionsCommunityRequest} from "../definitions/paths/set-public-options";
import {AuthToken} from "../../auth/service/AuthToken";
import {CreateCommunityResponse200, CreateCommunityRequest} from "../definitions/paths/create";
import {GetCommunityResponse200} from "../definitions/paths/get";
import {GetCommunityBySIDResponse200} from "../definitions/paths/get-by-sid";
import {SetPublicOptionsResponse200} from "../../collection/definitions/paths/set-public-optionts";
import {RESTService} from "../../common/service/RESTService";
import {CommunityActivateFeatureResponse200, CommunityActivateFeatureRequest} from "../definitions/paths/feature-activate";
import {CommunityDeactivateFeatureResponse200, CommunityDeactivateFeatureRequest} from "../definitions/paths/feature-deactivate";
import {CommunityIsActivatedFeatureRequest, CommunityIsActivatedFeatureResponse200} from "../definitions/paths/feature-is-activated";
import {UploadCommunityImageResponse200, UploadCommunityImageRequest} from "../definitions/paths/image-upload";

export interface CommunityRESTServiceInterface
{
    create(request: CreateCommunityRequest): Observable<CreateCommunityResponse200>;
    edit(communityId: number, request: EditCommunityRequest): Observable<EditCommunityResponse200>
    getCommunityById(id: number): Observable<GetCommunityResponse200>;
    getCommunityBySid(sid: string): Observable<GetCommunityBySIDResponse200>;
    setPublicOptions(communityId: number, request: SetPublicOptionsCommunityRequest): Observable<SetPublicOptionsResponse200>;
    activateFeature(request: CommunityActivateFeatureRequest): Observable<CommunityActivateFeatureResponse200>
    deactivateFeature(request: CommunityDeactivateFeatureRequest): Observable<CommunityDeactivateFeatureResponse200>;
    isFeatureActivated(request: CommunityIsActivatedFeatureRequest): Observable<CommunityIsActivatedFeatureResponse200>;
    imageUpload(communityId: number, request: UploadCommunityImageRequest): Observable<UploadCommunityImageResponse200>;
    imageDelete(request: CommunityImageDeleteRequest): Observable<DeleteCommunityImageResponse200>;
}

@Injectable()
export class CommunityRESTService implements CommunityRESTServiceInterface
{
    constructor(
        private service: RESTService,
        private token: AuthToken
    ) {}

    create(request: CreateCommunityRequest): Observable<CreateCommunityResponse200>
    {
        return this.service.put("/backend/api/protected/community/create", request);
    }

    edit(communityId: number, request: EditCommunityRequest): Observable<EditCommunityResponse200>
    {
        return this.service.post(`/backend/api/protected/community/${communityId}/edit`, request);
    }

    getCommunityById(id: number): Observable<GetCommunityResponse200>
    {
        return this.service.get(`/backend/api/community/${id}/get-by-id`);
    }

    getCommunityBySid(sid: string): Observable<GetCommunityBySIDResponse200>
    {
        return this.service.get(`/backend/api/community/${sid}/get-by-sid`);
    }

    setPublicOptions(communityId: number, request: SetPublicOptionsCommunityRequest): Observable<SetPublicOptionsResponse200>
    {
        return this.service.post(`/backend/api/protected/community/${communityId}/set-public-options`, request);
    }

    activateFeature(request: CommunityActivateFeatureRequest): Observable<CommunityActivateFeatureResponse200>
    {
        return this.service.put(`/backend/api/protected/community/${request.communityId}/feature/${request.feature}/activate`, {});
    };

    deactivateFeature(request: CommunityDeactivateFeatureRequest): Observable<CommunityDeactivateFeatureResponse200>
    {
        return this.service.delete(`/backend/api/protected/community/${request.communityId}/feature/${request.feature}/deactivate`);
    };

    isFeatureActivated(request: CommunityIsActivatedFeatureRequest): Observable<CommunityIsActivatedFeatureResponse200>
    {
        return this.service.get(`/backend/api/protected/community/${request.communityId}/feature/${request.feature}/is-activated`);
    }

    imageUpload(communityId: number, request: UploadCommunityImageRequest): Observable<UploadCommunityImageResponse200>
    {
        var progressBar: number = 0;

        return Observable.create(observer => {
            let formData: FormData = new FormData(),
                xhr: XMLHttpRequest = new XMLHttpRequest();

            formData.append("file", request.file);

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

            xhr.open("POST", `/backend/api/protected/community/${communityId}/image-upload/` +
                `crop-start/${request.crop.x1}/${request.crop.y1}/crop-end/${request.crop.x2}/${request.crop.y2}`);
            xhr.setRequestHeader('Authorization', this.token.apiKey);
            xhr.send(formData);
        });
    }

    imageDelete(request: CommunityImageDeleteRequest): Observable<DeleteCommunityImageResponse200>
    {
        return this.service.delete(`/backend/api/protected/community/${request.communityId}/image-delete`);
    }
}
