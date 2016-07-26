import {Module} from "../common/classes/Module";

import {ThemeService} from "./service/ThemeService";
import {ThemeRESTService} from "./service/ThemeRESTservice";

export = new Module({ 
    name: 'theme',
    RESTServices: [
        ThemeRESTService,
    ],
    providers: [
        ThemeService,
    ],
    directives: []
});