import {Component} from "angular2/core";

import {ROUTER_DIRECTIVES} from "angular2/router";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-feed-source-selector',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ROUTER_DIRECTIVES,
    ]
})
export class SourceSelector
{
    constructor(private catalog: PublicService) {}

    isOn(source: string) {
        return this.catalog.source === source;
    }
}