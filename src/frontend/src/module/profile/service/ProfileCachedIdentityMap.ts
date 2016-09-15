import {Observable} from "rxjs/Observable";
import {Injectable} from "@angular/core";
import {ProfileRESTService} from "./ProfileRESTService";
import {GetProfileByIdResponse200} from "../definitions/paths/get-by-id";

@Injectable()
export class ProfileCachedIdentityMap
{
    private entities: ProfileCachedIdentityMapDict = {};

    constructor(private service: ProfileRESTService) {}

    getProfileById(id: number): Observable<GetProfileByIdResponse200> {
        if(! this.entities[id]) {
            this.entities[id] = this.service.getProfileById(id);
        }

        return this.entities[id];
    }
}

interface ProfileCachedIdentityMapDict
{
    [id: number]: Observable<GetProfileByIdResponse200>;
}