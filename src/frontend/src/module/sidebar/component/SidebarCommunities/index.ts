import {Component} from "angular2/core";

import {CommunityModalService} from "../../../community/service/CommunityModalService";
import {Router, ROUTER_DIRECTIVES} from "angular2/router";
import {ProfileCommunityBookmarkEntity} from "../../../profile-communities/definitions/ProfileCommunityBookmark";
import {Session} from "../../../session/Session";
import {queryImage, QueryTarget} from "../../../avatar/functions/query";
import {ProfileCommunityBookmarksService} from "../../../profile-communities/service/ProfileCommunityBookmarksService";

@Component({
    selector: 'cass-sidebar-communities',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
export class SidebarCommunities
{
    private isSwitchedCommunityBookmarks: boolean = true;

    constructor(
        private session: Session,
        private communityModalService: CommunityModalService,
        private bookmarks: ProfileCommunityBookmarksService
    ) {}

    isSwitched() {
        return this.isSwitchedCommunityBookmarks;
    }
    
    getCommunityBookmarks(): ProfileCommunityBookmarkEntity[] {
        if(this.session.isSignedIn()){
            return this.bookmarks.getBookmarks();
        }
    }

    getCommunityLinkParams(communitySID: string) {
        return ['/Community', 'Community', { sid: communitySID }];
    }
    
    getCommunityImage(bookmark: ProfileCommunityBookmarkEntity): string {
        return queryImage(QueryTarget.Avatar, bookmark.community.image).public_path;
    }

    switchCommunityBookmarks() {
        this.isSwitchedCommunityBookmarks = !this.isSwitchedCommunityBookmarks;
    }

    openCommunityModal() {
        this.communityModalService.modals.route.open();
    }
}