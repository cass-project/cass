import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {EditPersonalRequest, EditPersonalResponse200} from "../definitions/paths/edit-personal";
import {SetGenderRequest, SetGenderResponse200} from "../definitions/paths/set-gender";
import {DeleteProfileImageResponse200} from "../definitions/paths/image-delete";
import {RESTService} from "../../common/service/RESTService";
import {GetProfileByIdResponse200} from "../definitions/paths/get-by-id";
import {GetProfileBySIDResponse200} from "../definitions/paths/get-by-sid";
import {CreateProfileResponse200} from "../definitions/paths/create";
import {InterestingInRequest, InterestingInResponse200} from "../definitions/paths/interesting-in-ids";
import {ExpertInRequest, ExpertInResponse200} from "../definitions/paths/expert-in-ids";
import {SwitchToProfileResponse200} from "../../account/definitions/paths/switch-to-profile";
import {DeleteProfileResponse200} from "../definitions/paths/delete";
import {UploadProfileImageRequest, UploadProfileImageProgress, UploadProfileImageResponse200} from "../definitions/paths/image-upload";
import {AuthToken} from "../../auth/service/AuthToken";

export interface ProfileRESTServiceInterface
{
    getProfileById(profileId: number): Observable<GetProfileByIdResponse200>;
    getProfileBySID(profileSID: string): Observable<GetProfileBySIDResponse200>;
    createNewProfile(): Observable<CreateProfileResponse200>;
    setGender(profileId: number, request: SetGenderRequest): Observable<SetGenderResponse200>;
    setInterestingIn(profileId: number, request: InterestingInRequest): Observable<InterestingInResponse200>;
    setExpertIn(profileId: number, request: ExpertInRequest): Observable<ExpertInResponse200>;
    editPersonal(profileId: number, request: EditPersonalRequest): Observable<EditPersonalResponse200>;
    switchProfile(profileId: number): Observable<SwitchToProfileResponse200>;
    deleteProfile(profileId: number): Observable<DeleteProfileResponse200>;
    imageUpload(profileId: number, request: UploadProfileImageRequest): Observable<UploadProfileImageProgress|UploadProfileImageResponse200>;
    imageDelete(profileId: number): Observable<DeleteProfileImageResponse200>;
}

@Injectable()
export class ProfileRESTService implements ProfileRESTServiceInterface
{
    constructor(private rest: RESTService, private token: AuthToken) {}

    getProfileById(profileId: number): Observable<GetProfileByIdResponse200> {
        return this.rest.get(`/backend/api/profile/${profileId}/get`);
    }

    getProfileBySID(profileSID: string): Observable<GetProfileBySIDResponse200> {
        return this.rest.get(`/backend/api/profile/by-sid/${profileSID}/get`);
    }

    createNewProfile(): Observable<CreateProfileResponse200> {
        return this.rest.put(`/backend/api/protected/profile/create`, {});
    }

    setGender(profileId: number, request: SetGenderRequest): Observable<SetGenderResponse200> {
        return this.rest.post(`/backend/api/protected/profile/${profileId}/set-gender/`, request);
    }

    setInterestingIn(profileId: number, request: InterestingInRequest): Observable<InterestingInResponse200> {
        return this.rest.post(`/backend/api/protected/profile/${profileId}/interesting-in/`, request);
    }

    setExpertIn(profileId: number, request: ExpertInRequest): Observable<ExpertInResponse200> {
        return this.rest.post(`/backend/api/protected/profile/${profileId}/expert-in/`, request);
    }

    editPersonal(profileId: number, request: EditPersonalRequest): Observable<EditPersonalResponse200> {
        return this.rest.post(`/backend/api/protected/profile/${profileId}/edit-personal/`, request);
    }

    switchProfile(profileId: number): Observable<SwitchToProfileResponse200> {
        return this.rest.post(`/backend/api/protected/account/switch/to/profile/${profileId}/`, {});
    }

    deleteProfile(profileId: number): Observable<DeleteProfileResponse200> {
        return this.rest.delete(`/backend/api/protected/profile/${profileId}/delete`);
    }

    imageUpload(profileId: number, request: UploadProfileImageRequest): Observable<UploadProfileImageProgress|UploadProfileImageResponse200>
    {
        return Observable.create(observer => {
            let xhrRequest = new XMLHttpRequest();
            let formData = new FormData();
            let url = `/backend/api/protected/profile/${profileId}/image-upload`
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
                    if(xhrRequest.status === 200) {
                        observer.next(xhrRequest.response);
                        observer.complete();
                    }else{
                        observer.error(xhrRequest.response);
                    }
                }
            };
        });
    }

    imageDelete(profileId: number): Observable<DeleteProfileImageResponse200> {
        return this.rest.delete(`/backend/api/protected/profile/${profileId}/image-delete`);
    }
}