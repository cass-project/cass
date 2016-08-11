import {Module} from "../common/classes/Module";
import {CommunityFeaturesService} from "./service/CommunityFeaturesService";

export = new Module({ 
    name: 'community-features',
    RESTServices: [],
    providers: [
        CommunityFeaturesService
    ],
    directives: []
});