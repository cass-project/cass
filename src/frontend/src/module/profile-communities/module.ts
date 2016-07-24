import {Module} from "../common/classes/Module";

import {ProfileCommunityBookmarksService} from "./service/ProfileCommunityBookmarksService";
import {ProfileCommunitiesRESTService} from "./service/ProfileCommunitiesRESTService";

export = new Module({ 
    name: 'profile-communities',
    RESTServices: [
        ProfileCommunitiesRESTService,
    ],
    providers: [
        ProfileCommunityBookmarksService
    ],
    directives: []
});