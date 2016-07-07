import {Component} from "angular2/core";
import {SearchCriteriaService} from "../../../search/SearchCriteriaService";

@Component({
    selector: 'cass-public-search-criteria-seek',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SeekCriteria
{
    constructor(private service: SearchCriteriaService) {}
}