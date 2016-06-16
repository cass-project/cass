import {Injectable} from 'angular2/core';
import {Http} from 'angular2/http';
import {AuthService} from "../../auth/service/AuthService";

@Injectable()
export class CollectionRESTService {
    constructor(public http:Http) {}

    profileCreateCollection(profileId, collection){
        let url = `/backend/api/protected/profile/collection/create`;

        return this.http.put(url, JSON.stringify({
            author_profile_id: profileId,
            theme_id: collection.theme_id,
            title: collection.title,
            description: collection.description
        }));

    }

    communityCreateCollection(communityId, collection){
        let url = `/backend/api/protected/community/${communityId}/collection/create`;

        return this.http.put(url, JSON.stringify({
            author_profile_id: AuthService.getAuthToken().getCurrentProfile().getId(),
            theme_id: collection.theme_id,
            title: collection.title,
            description: collection.description
        }));
    }
}