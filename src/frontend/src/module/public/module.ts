import {Module} from "../common/classes/Module";

import {PublicService} from "./service";
import {PublicComponent} from "./index";

export = new Module({ 
    name: 'public',
    RESTServices: [],
    providers: [
        PublicService,
    ]/*,
    routes: [
        {
            name: 'Public',
            path: '/public/...',
            component: PublicComponent,
            useAsDefault: true
        }
    ]*/
});