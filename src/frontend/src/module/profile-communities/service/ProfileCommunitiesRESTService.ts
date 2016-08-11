import {Injectable} from "@angular/core";
import {Http} from "@angular/http"

import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {MessageBusService} from "../../message/service/MessageBusService/index";
import {AuthToken} from "../../auth/service/AuthToken";
import {Observable} from "rxjs/Observable";
import {JoinCommunityResponse200} from "../entity/join";
import {JoinedCommunitiesResponse200} from "../entity/joined-communities";
import {LeaveCommunityResponse200} from "../entity/leave";

@Injectable()
export class ProfileCommunitiesRESTService extends AbstractRESTService
{
    constructor(protected http: Http,
                protected token: AuthToken,
                protected messages: MessageBusService) {
        super(http, token, messages);
    }

    getJoinedCommunities(profileId: number): Observable<JoinedCommunitiesResponse200> {
        let url = `/backend/api/protected/with-profile/${profileId}/community/list/joined-communities`;

        return this.handle(
            this.http.get(url, {
                headers: this.getAuthHeaders()
            })
        );
    }

    joinCommunity(profileId: number, communitySID: string): Observable<JoinCommunityResponse200> {
        let url = `/backend/api/protected/with-profile/${profileId}/community/${communitySID}/join`;

        return this.handle(
            this.http.put(url, '', {
                headers: this.getAuthHeaders()
            })
        );
    }

    leaveCommunity(profileId: number, communitySID: string): Observable<LeaveCommunityResponse200> {
        let url = `/backend/api/protected/with-profile/${profileId}/community/${communitySID}/leave`;

        return this.handle(
            this.http.put(url, '', {
                headers: this.getAuthHeaders()
            })
        );
    }
}