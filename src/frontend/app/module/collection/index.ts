import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

@Component({
    template: require('./template.html'),
    directives: [
        ROUTER_DIRECTIVES
    ]
})
export class CollectionComponent {}