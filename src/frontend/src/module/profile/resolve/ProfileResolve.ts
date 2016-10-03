import {Injectable} from "@angular/core";
import {Resolve, ActivatedRouteSnapshot, RouterStateSnapshot, Router} from "@angular/router";
import {Observable} from "rxjs/Rx";

import {ProfileExtendedEntity} from "../definitions/entity/Profile";
import {Session} from "../../session/Session";
import {GetProfileByIdResponse200} from "../definitions/paths/get-by-id";
import {ProfileRESTService} from "../service/ProfileRESTService";

@Injectable()
export class ProfileResolve implements Resolve<ProfileExtendedEntity>
{
    constructor(
        private api: ProfileRESTService,
        private session: Session,
        private router: Router
    ) {}

    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<GetProfileByIdResponse200>|boolean {
        let id = route.params['id'];

        if (id === 'current' || (this.session.isSignedIn() && id === this.session.getCurrentProfile().getId().toString())) {
            if(this.session.isSignedIn()) {
                return this.loadCurrentProfile();
            }else{
                this.router.navigate(['/home']);
            }
        } else if (Number(id)) {
            return this.loadProfileById(Number(id));
        } else {
            this.router.navigate(['/profile/not-found']);
        }

        return false;
    }

    public loadCurrentProfile() {
        return new Observable<GetProfileByIdResponse200>(observer => {
            observer.next({
                success: true,
                entity: this.session.getCurrentProfile().entity
            });
            observer.complete();
        });
    }

    public loadProfileById(id: number) {
        return this.api.getProfileById(id);
    }

    public loadProfileBySID(sid: string) {
        return this.api.getProfileBySID(sid);
    }
}