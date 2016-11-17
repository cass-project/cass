import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";

import {SubscribeCollection} from "../definitions/paths/subscribe-collection";
import {RESTService} from "../../common/service/RESTService";
import {SubscribeProfile} from "../definitions/paths/subscribe-profile";
import {ListSubscribeProfiles} from "../definitions/paths/list-profiles";
import {ListSubscribeProfileRequest} from "../definitions/paths/list-profiles";
import {SubscribeCommunity} from "../definitions/paths/subscribe-community";
import {SubscribeTheme} from "../definitions/paths/subscribe-theme";
import {UnsubscribeCommunity} from "../definitions/paths/unsubscribe-community";
import {UnsubscribeProfile} from "../definitions/paths/unsubscribe-profile";
import {UnsubscribeTheme} from "../definitions/paths/unsubscribe-theme";
import {ListSubscribeCommunities} from "../definitions/paths/list-communities";
import {ListSubscribeCommunitiesRequest} from "../definitions/paths/list-communities";
import {ListSubscribeCollections} from "../definitions/paths/list-collections";
import {ListSubscribeCollectionsRequest} from "../definitions/paths/list-collections";
import {ListSubscribeThemesRequest} from "../definitions/paths/list-themes";
import {ListSubscribeThemes} from "../definitions/paths/list-themes";
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
    listCommunities(communityID: number, request: ListSubscribeCommunitiesRequest): Observable<ListSubscribeCommunities>;
    listProfiles(profileID: number, request: ListSubscribeProfileRequest): Observable<ListSubscribeProfiles>;
    listTheme(themeID: number, request: ListSubscribeThemesRequest): Observable<ListSubscribeThemes>;
    listCollections(collectionId: number, request: ListSubscribeCollectionsRequest): Observable<ListSubscribeCollections>;
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

    listCommunities(profileID: number, request: ListSubscribeCommunitiesRequest): Observable<ListSubscribeCommunities>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${profileID}/list-communities`, request);
    }

    listProfiles(profileID: number, request: ListSubscribeProfileRequest): Observable<ListSubscribeProfiles>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${profileID}/list-profiles`, request);
    }

    listTheme(themeID: number, request: ListSubscribeThemesRequest): Observable<ListSubscribeThemes>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${themeID}/list-themes`, request);
    }

    listCollections(profileId: number, request: ListSubscribeCollectionsRequest): Observable<ListSubscribeCollections>
    {
        return this.rest.post(`/backend/api/subscribe/profile/${profileId}/list-collections`, request);
    }
}