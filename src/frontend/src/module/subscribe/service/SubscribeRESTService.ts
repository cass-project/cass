import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {SubscribeCollection} from "../definitions/paths/subscribe-collection";
import {RESTService} from "../../common/service/RESTService";
import {SubscribeProfile} from "../definitions/paths/subscribe-profile";
import {ListProfiles} from "../definitions/paths/list-profiles";
import {ListProfileRequest} from "../definitions/paths/list-profiles";
import {SubscribeCommunity} from "../definitions/paths/subscribe-community";
import {SubscribeTheme} from "../definitions/paths/subscribe-theme";
import {UnsubscribeCommunity} from "../definitions/paths/unsubscribe-community";
import {UnsubscribeProfile} from "../definitions/paths/unsubscribe-profile";
import {UnsubscribeTheme} from "../definitions/paths/unsubscribe-theme";
import {ListCommunities} from "../definitions/paths/list-communities";
import {ListCommunitiesRequest} from "../definitions/paths/list-communities";
import {ListCollections} from "../definitions/paths/list-collections";
import {ListCollectionsRequest} from "../definitions/paths/list-collections";
import {ListThemesRequest} from "../definitions/paths/list-themes";
import {ListThemes} from "../definitions/paths/list-themes";
import {UnsubscribeCollection} from "../definitions/paths/unsubscribe-collection";

export interface SubscribeRESTServiceInterface
{
    subscribeCollection(collectionId: number): Observable<SubscribeCollection>;
    subscribeCommunity(communityID: number): Observable<SubscribeCommunity>;
    subscribeProfile(profileId: number): Observable<SubscribeProfile>;
    subscribeTheme(themeId: number): Observable<SubscribeTheme>;
    unsubscribeCommunity(communityID: number): Observable<UnsubscribeCommunity>;
    unsubscribeProfile(profileID: number): Observable<UnsubscribeProfile>;
    unsubscribeTheme(themeID: number): Observable<UnsubscribeTheme>;
    unsubscribeCollection(collectionID: number): Observable<UnsubscribeCollection>;
    listCommunities(communityID: number, request: ListCommunitiesRequest): Observable<ListCommunities>;
    listProfiles(profileID: number, request: ListProfileRequest): Observable<ListProfiles>;
    listTheme(themeID: number, request: ListThemesRequest): Observable<ListThemes>;
    listCollections(collectionId: number, request: ListCollectionsRequest): Observable<ListCollections>;
}

@Injectable()
export class SubscribeRESTService implements SubscribeRESTServiceInterface
{
    constructor(private rest: RESTService) {}

    subscribeCollection(collectionId: number): Observable<SubscribeCollection>
    {
        return this.rest.put(`/backend/api/protected/subscribe/subscribe-collection/${collectionId}`, {});
    }

    subscribeCommunity(communityID: number): Observable<SubscribeCommunity>
    {
        return this.rest.put(`/backend/api/protected/subscribe/subscribe-community/${communityID}`, {});
    }

    subscribeProfile(profileId: number): Observable<SubscribeProfile>
    {
        return this.rest.put(`/backend/api/protected/subscribe/subscribe-profile/${profileId}`, {});
    }

    subscribeTheme(themeId: number): Observable<SubscribeTheme>
    {
        return this.rest.put(`/backend/api/protected/subscribe/subscribe-theme/${themeId}`, {});
    }

    unsubscribeCommunity(communityID: number): Observable<UnsubscribeCommunity>
    {
        return this.rest.delete(`/backend/api/protected/subscribe/unsubscribe-community/${communityID}`, {});
    }

    unsubscribeProfile(profileID: number): Observable<UnsubscribeProfile>
    {
        return this.rest.delete(`/backend/api/protected/subscribe/unsubscribe-profile/${profileID}`, {});
    }

    unsubscribeTheme(themeID: number): Observable<UnsubscribeTheme>
    {
        return this.rest.delete(`/backend/api/protected/subscribe/unsubscribe-theme/${themeID}`, {});
    }

    unsubscribeCollection(collectionID: number): Observable<UnsubscribeCollection>
    {
        return this.rest.delete(`/backend/api/protected/subscribe/unsubscribe-collection${collectionID}`, {});
    }

    listCommunities(communityID: number, request: ListCommunitiesRequest): Observable<ListCommunities>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${communityID}/list-communities`, request);
    }

    listProfiles(profileID: number, request: ListProfileRequest): Observable<ListProfiles>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${profileID}/list-profiles`, request);
    }

    listTheme(themeID: number, request: ListThemesRequest): Observable<ListThemes>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${themeID}/list-themes`, request);
    }

    listCollections(collectionId: number, request: ListCollectionsRequest): Observable<ListCollections>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${collectionId}/list-collections`, request);
    }
}