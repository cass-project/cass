import {Injectable} from "angular2/core";
import {Observable} from "rxjs/Observable";

import {GetCommunityBySIDResponse200} from "../../community/definitions/paths/get-by-sid";
import {ProfileRESTService} from "./ProfileRESTService";

@Injectable()
export class CurrentProfileService
{
    private observable: Observable<GetCommunityBySIDResponse200>;

    constructor(private api: ProfileRESTService) {}

    public loadProfileById(id: number) {
        this.observable = <any>this.api.getProfileById(id);
    }

    public loadProfileBySID(sid: string) {
        this.observable = <any>this.api.getProfileBySID(sid);
    }

    public loadCurrentProfile() {
        throw new Error('Not implemented');
    }

    public getProfileObservable() {
        return this.observable;
    }
}