import {Module} from "../common/classes/Module";
import {PostRESTService} from "./service/PostRESTService";
import {PostTypeService} from "./service/PostTypeService";

export = new Module({ 
    name: 'post',
    RESTServices: [
        PostRESTService,
    ],
    providers: [
        PostTypeService,
    ],
    directives: []
});