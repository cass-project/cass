import {Injectable} from 'angular2/core';
import {Http, Headers} from "angular2/http"
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {EditPersonalRequest} from "../definitions/paths/edit-personal";
import {SetGenderRequest, SetGenderResponse200} from "../definitions/paths/set-gender";
import {ExpertInRequest, ExpertInResponse200} from "../definitions/paths/expert-in-ids";
import {AuthToken} from "../../auth/service/AuthToken";

@Injectable()
export class ProfileRESTService extends AbstractRESTService
{
    constructor(
        protected http: Http,
        protected token: AuthToken,
        protected messages: MessageBusService
    ) { super(http, token, messages); }

    getProfileById(profileId: number) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/profile/${profileId}/get`, {headers: authHeader}));
    }

    getProfileBySID(profileSID: string) {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.get(`/backend/api/profile/by-sid/${profileSID}/get`, {headers: authHeader}));
    }

    createNewProfile() {
        let authHeader = new Headers();
        
        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put(`/backend/api/protected/profile/create`, '', {headers: authHeader}));
    }

    setGender(profileId: number, request: SetGenderRequest) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/profile/${profileId}/set-gender/`, JSON.stringify(request), {headers: authHeader}));
    }

    setInterestingIn(profileId: number, request) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put(`/backend/api/protected/profile/${profileId}/interesting-in/`, JSON.stringify(request), {headers: authHeader}));
    }

    setExpertIn(profileId: number, request) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put(`/backend/api/protected/profile/${profileId}/expert-in/`, JSON.stringify(request), {headers: authHeader}));
    }

    editPersonal(profileId: number, request: EditPersonalRequest) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        let url = `/backend/api/protected/profile/${profileId}/edit-personal/`;

        return this.handle(this.http.post(url, JSON.stringify(request), {headers: authHeader}));
    }

    switchProfile(profileId) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.post(`/backend/api/protected/account/switch/to/profile/${profileId}`, '', {headers: authHeader}));
    }

    deleteProfile(profileId) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/profile/${profileId}/delete`, {headers: authHeader}));
    }

    requestAccountDeleteCancel() {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/account/cancel-request-delete`, {headers: authHeader}));
    }

    requestAccountDelete() {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.put(`/backend/api/protected/account/request-delete`, '', {headers: authHeader}));
    }

    deleteAvatar(profileId: number) {
        let authHeader = new Headers();

        if(this.token.hasToken()){
            authHeader.append('Authorization', `${this.token.apiKey}`);
        }

        return this.handle(this.http.delete(`/backend/api/protected/profile/${profileId}/image-delete`, {headers: authHeader}));
    }
}