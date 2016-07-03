import {ProfileExtendedEntity} from "../definitions/entity/Profile";
import {ProfileRESTService} from "./ProfileRESTService";
import {Observable} from "rxjs/Observable";
import {Injectable} from "angular2/core";
import {GetProfileByIdResponse200} from "../definitions/paths/get-by-id";
import {Response} from "angular2/http";

@Injectable()
export class ProfileCachedIdentityMap
{
    private entities: ProfileCachedIdentityMapDict = {};

    constructor(private service: ProfileRESTService) {}

    getProfileById(id: number): Observable<ProfileExtendedEntity> {
        if(! this.entities[id]) {
            this.entities[id] = new Observable(observer => {
                this.service.getProfileById(id).subscribe(
                    (response: GetProfileByIdResponse200) => {
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