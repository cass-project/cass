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
import {
    UploadCommunityImageResponse200, UploadCommunityImageRequest,
    UploadCommunityImageProgress
} from "../definitions/paths/image-upload";

export interface CommunityRESTServiceInterface
{
    create(request: CreateCommunityRequest): Observable<CreateCommunityResponse200>;
    edit(communityId: number, request: EditCommunityRequest): Observable<EditCommunityResponse200>
    getCommunityById(id: string): Observable<GetCommunityResponse200>;
    getCommunityBySid(sid: string): Observable<GetCommunityBySIDResponse200>;
    setPublicOptions(communityId: number, request: SetPublicOptionsCommunityRequest): Observable<SetPublicOptionsResponse200>;
    activateFeature(request: CommunityActivateFeatureRequest): Observable<CommunityActivateFeatureResponse200>
    deactivateFeature(request: CommunityDeactivateFeatureRequest): Observable<CommunityDeactivateFeatureResponse200>;
    isFeatureActivated(request: CommunityIsActivatedFeatureRequest): Observable<CommunityIsActivatedFeatureResponse200>;
    imageUpload(communityId: number, request: UploadCommunityImageRequest): Observable<UploadCommunityImageProgress|UploadCommunityImageResponse200>;
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

    getCommunityById(id: string): Observable<GetCommunityResponse200>
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

    imageUpload(communityId: number, request: UploadCommunityImageRequest): Observable<UploadCommunityImageProgress|UploadCommunityImageResponse200>
    {
        return Observable.create(observer => {
            let xhrRequest = new XMLHttpRequest();
            let formData = new FormData();
            let url = `/backend/api/protected/community/${communityId}/image-upload`
                + `/crop-start/${request.crop.x1}/${request.crop.y1}`
                + `/crop-end/${request.crop.x2}/${request.crop.y2}`;


            formData.append("file", request.file);

            xhrRequest.open("POST", url);
            xhrRequest.setRequestHeader('Authorization', this.token.getAPIKey());
            xhrRequest.send(formData);

            xhrRequest.onprogress = (e) => {
                if (e.lengthComputable) {
                    observer.next({
                        progress: Math.floor((e.loaded / e.total) * 100)
                    });
                }
            };

            xhrRequest.onreadystatechange = () => {
                if (xhrRequest.readyState === 4) {
                    try {
                        let json = JSON.parse(xhrRequest.response);

                        if (xhrRequest.status === 200) {
                            observer.next(json);
                            observer.complete();
                        } else {
                            observer.error(json);
                        }
                    } catch (e) {
                        observer.error('Failed to parse JSON');
                    }
                }
            };
        });
    }

    imageDelete(request: CommunityImageDeleteRequest): Observable<DeleteCommunityImageResponse200>
    {
        return this.service.delete(`/backend/api/protected/community/${request.communityId}/image-delete`);
    }
}
