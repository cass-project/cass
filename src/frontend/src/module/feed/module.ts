import {Module} from "../common/classes/Module";

import {FeedRESTService} from "./service/FeedRESTService";

export = new Module({ 
    name: 'feed',
    RESTServices: [
        FeedRESTService,
    ],
    providers: [],
    directives: []
});