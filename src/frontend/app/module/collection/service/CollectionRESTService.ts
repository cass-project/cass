import {Injectable} from 'angular2/core';
import {Http} from 'angular2/http';

@Injectable()
export class CollectionRESTService {
    constructor(public http:Http) {}

    profileCreateCollection(collection){
        let url = `/backend/api/protected/profile/collection/create`;

        return this.http.put(url, JSON.stringify({
            author_profile_id: collection.author_profile_id,
            theme_id: 0,
            title: collection.title,
            description: collection.description
        }));

    }

    communityCreateCollection(collection){
        let url = `/backend/api/protected/community/${collection.owner_community_id}/collection/create`;

        return this.http.put(url, JSON.stringify({
            author_profile_id: collection.author_profile_id,
            theme_id: collection.theme_id,
            title: collection.title,
            description: collection.description
        }));
    }
}