import {Component} from "@angular/core";

import {ROUTER_DIRECTIVES} from '@angular/router';
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