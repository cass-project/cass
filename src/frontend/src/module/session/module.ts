import {Module} from "../common/classes/Module";

import {Session} from "./Session";

export = new Module({ 
    name: 'session',
    providers: [
        Session,
    ],
});