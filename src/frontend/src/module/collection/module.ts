import {Module} from "../common/classes/Module";

import {CollectionModals} from "./modals";
import {CollectionRESTService} from "./service/CollectionRESTService";

export = new Module({ 
    name: 'collection',
    RESTServices: [
        CollectionRESTService,
    ],
    providers: [
        CollectionModals,
    ],
    directives: []
});