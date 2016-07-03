import {Observable} from "rxjs/Observable";
import {Injectable} from "angular2/core";

import {ProfileExtendedEntity} from "../definitions/entity/Profile";
import {ProfileRESTService} from "./ProfileRESTService";

@Injectable()
export class ProfileCachedIdentityMap
{
    private entities: ProfileCachedIdentityMapDict = {};

    constructor(private service: ProfileRESTService) {}

    getProfileById(id: number): Observable<ProfileExtendedEntity> {
        if(! this.entities[id]) {
            this.entities[id] = new Observable(observer => {
                this.service.getProfileById(id).map(res => res.json()).subscribe(
                    (response) => {
                        observer.next(response.entity);
                        observer.complete();
                    },
                    (error) => {
                        observer.error(error);
                    }
                )
            });
        }

        return this.entities[id];
    }
}

interface ProfileCachedIdentityMapDict
{
    [id: number]: Observable<ProfileExtendedEntity>;
}