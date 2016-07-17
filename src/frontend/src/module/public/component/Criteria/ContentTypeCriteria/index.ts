import {Component, Output, EventEmitter} from "angular2/core";

@Component({
    selector: 'cass-public-criteria-content-type',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentTypeCriteria
{
}