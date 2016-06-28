import {Injectable} from 'angular2/core';
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {EditPersonalRequest} from "../definitions/paths/edit-personal";

@Injectable()
export class ProfileRESTService extends AbstractRESTService
{
    getProfileById(profileId: number) {
        return this.handle(this.http.get(`/backend/api/profile/${profileId}/get`));
    }

    getProfileBySID(profileSID: string) {
        return this.handle(this.http.get(`/backend/api/profile/by-sid/${profileSID}/get`));
    }

    createNewProfile() {
        return this.handle(this.http.put(`/backend/api/protected/profile/create`, ''));
    }

    editPersonal(profileId: number, request: EditPersonalRequest) {
        let url = `/backend/api/protected/profile/${profileId}/edit-personal/`;

        return this.handle(this.http.post(url, JSON.stringify(request)));
    }

    switchProfile(profileId) {
        return this.handle(this.http.post(`/backend/api/protected/profile/${profileId}/switch/`, JSON.stringify('')));
    }

    deleteProfile(profileId) {
        return this.handle(this.http.delete(`/backend/api/protected/profile/${profileId}/delete`));
    }

    requestAccountDeleteCancel() {
        return this.handle(this.http.delete(`/backend/api/protected/account/cancel-request-delete`));
    }

    requestAccountDelete() {
        return this.handle(this.http.put(`/backend/api/protected/account/request-delete`, JSON.stringify('')));
    }

    deleteAvatar(profileId: number) {
        return this.handle(this.http.delete(`/backend/api/protected/profile/${profileId}/image-delete`));
    }
}