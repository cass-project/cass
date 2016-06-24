import {Injectable} from "angular2/core";
import {Http} from "angular2/http"
import {AbstractRESTService} from "../../common/service/AbstractRESTService";
import {Account} from "../../account/definitions/entity/Account";
import {MessageBusService} from "../../message/service/MessageBusService/index";

@Injectable()
export class ProfileCommunitiesRESTService extends AbstractRESTService {
    constructor(protected  http:Http, protected messages:MessageBusService) {
        super(http, messages);
    }

    getJoinedCommunities()
    {
        return this.handle(this.http.get(`/backend/api/protected/profile/current/joined-communities`));
    }

    joinCommunity(communitySID){
        return this.handle(this.http.put(`/backend/api/protected/community/${communitySID}/join`, JSON.stringify({})));
    }

    leaveCommunity(communitySID){
        return this.handle(this.http.put(`/backend/api/protected/community/${communitySID}/leave`, JSON.stringify({})));
    }
}