import {Module} from "../common/classes/Module";

import {FeedbackComponent} from "./index";

export = new Module({ 
    name: 'feedback',
    RESTServices: [],
    providers: [],
    directives: [
        FeedbackComponent,
    ]
});