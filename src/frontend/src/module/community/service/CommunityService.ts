import {Injectable} from "@angular/core";

import {Router} from "@angular/router";
import {CommunityEntity} from "../definitions/entity/Community";

@Injectable()
export class CommunityService
{
    constructor(private router: Router) {}

    getRouterParams(community: CommunityEntity) {
        return ['/', 'community', community.sid];
    }
    
    navigateCommunity(community: CommunityEntity) {
        this.router.navigate(this.getRouterParams(community));
    }
}