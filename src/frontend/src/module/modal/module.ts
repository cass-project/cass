import {Module} from "../common/classes/Module";

import {ModalService} from "./component/service";

export = new Module({ 
    name: 'modal',
    RESTServices: [],
    providers: [
        ModalService,
    ],
    directives: []
});