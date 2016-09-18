import {Component} from "@angular/core";
import {PublicService} from "../../../service";

@Component({
    selector: 'cass-public-search-criteria-seek',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SeekCriteria
{
    constructor(private service: PublicService) {}
}