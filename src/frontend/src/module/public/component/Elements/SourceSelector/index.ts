import {Component, Directive} from "@angular/core";

import {PublicService} from "../../../service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-public-feed-source-selector'})

export class SourceSelector
{
    constructor(private catalog: PublicService) {}

    isOn(source: string) {
        return this.catalog.source === source;
    }
}