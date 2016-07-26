import {Module} from "../common/classes/Module";

import {PostAttachmentRESTService} from "./service/PostAttachmentRESTService";

export = new Module({ 
    name: 'post-attachment',
    RESTServices: [
        PostAttachmentRESTService,
    ],
    providers: [],
    directives: []
});