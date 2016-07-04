import {Observable} from "rxjs/Observable";
import {Injectable} from "angular2/core";

import {ProfileExtendedEntity} from "../definitions/entity/Profile";
import {ProfileRESTService} from "./ProfileRESTService";
import {GetProfileByIdResponse200} from "../definitions/paths/get-by-id";

@Injectable()
export class ProfileCachedIdentityMap
{
    private entities: ProfileCachedIdentityMapDict = {};

    constructor(private service: ProfileRESTService) {}

    getProfileById(id: number): Observable<GetProfileByIdResponse200> {
        if(! this.entities[id]) {
            this.entities[id] = this.service.getProfileById(id).map(res => res.json());
        }

        return this.entities[id];
    }
}

interface ProfileCachedIdentityMapDict
{
    [id: number]: Observable<GetProfileByIdResponse200>;
}