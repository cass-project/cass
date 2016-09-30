import {Injectable} from "@angular/core";
import {Resolve, ActivatedRouteSnapshot, RouterStateSnapshot, Router} from "@angular/router";
import {Observable} from "rxjs/Rx";

import {Session} from "../../session/Session";
import {GetCommunityBySIDResponse200} from "../definitions/paths/get-by-sid";
import {CommunityRESTService} from "../service/CommunityRESTService";
import {CommunityExtendedEntity} from "../definitions/entity/CommunityExtended";

@Injectable()
export class CommunityResolve implements Resolve<CommunityExtendedEntity>
{
    constructor(
        private api: CommunityRESTService,
        private session: Session,
        private router: Router
    ) {}

    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): Observable<GetCommunityBySIDResponse200>|boolean {
        let sid = route.params['sid'];

        if(sid) {
            return this.loadCommunityBySID(sid);
        } else {
            this.router.navigate(['/community/not-found']);
        }

        return false;
    }

    public loadCommunityById(id: number) {
        return this.api.getCommunityById(id);
    }

    public loadCommunityBySID(sid: string) {
        return this.api.getCommunityBySid(sid);
    }
}