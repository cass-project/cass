import {Component} from "angular2/core";
import {ROUTER_DIRECTIVES} from "angular2/router";

import {CollectionsList} from "../../../collection/component/Elements/CollectionsList/index";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
        CollectionsList,
    ]
})
export class ProfileCollectionsListRoute
{
}