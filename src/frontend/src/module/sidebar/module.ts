import {Module} from "../common/classes/Module";
import {SidebarComponent} from "./index";

export = new Module({ 
    name: 'sidebar',
    RESTServices: [],
    providers: [],
    directives: [
        SidebarComponent,
    ]
});