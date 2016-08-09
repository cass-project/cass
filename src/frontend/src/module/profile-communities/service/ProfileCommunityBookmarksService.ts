import {Injectable} from "@angular/core";

import {ProfileCommunityBookmarkEntity} from "../definitions/ProfileCommunityBookmark";
import {CommunityEntity} from "../../community/definitions/entity/Community";
import {Session} from "../../session/Session";
import {CommunityCreateModalNotifier} from "../../community/component/Modal/CommunityCreateModal/notify";

@Injectable()
export class ProfileCommunityBookmarksService
{
    constructor(
        private session: Session,
        private communities: CommunityCreateModalNotifier
    ) {
        communities.observable.subscribe(entity => {
            if(session.isSignedIn()) {
                this.attachBookmark(entity.community);
            }
        });
    }

    isAvailable(): boolean {
        return this.session.isSignedIn();
    }

    getBookmarks(): ProfileCommunityBookmarkEntity[] {
        if(this.session.isSignedIn()){
            return this.session.getCurrentProfile().entity.bookmarks;
        } 
    }

    attachBookmark(community: CommunityEntity): ProfileCommunityBookmarkEntity {
        let profile = this.session.getCurrentProfile();
        let inserted: ProfileCommunityBookmarkEntity = {
            community_id: community.id,
            community_sid: community.sid,
            profile_id: profile.getId(),
            community: community
        };

        profile.entity.bookmarks.push(inserted);
        
        return inserted;
    }

    hasBookmark(communitySID: string): boolean {
        return this.isAvailable()
            && this.session.getCurrentProfile().entity.bookmarks.filter(
                bookmark => bookmark.community_sid === communitySID
            ).length > 0;
    }

    detachBookmark(communitySID: string) {
        if (this.hasBookmark(communitySID)) {
            let profile = this.session.getCurrentProfile();
            let deleted = profile.entity.bookmarks.filter(
                bookmark => bookmark.community_sid === communitySID
            )[0];

            profile.entity.bookmarks = profile.entity.bookmarks.filter(compare => {
                return compare.community_id !== deleted.community_id;
            });
        }
    }
}