import {Component, Directive} from "@angular/core";

import {PublicService} from "../../../service";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-public-search-criteria-seek'})

export class SeekCriteria
{
    constructor(private service: PublicService) {}
}