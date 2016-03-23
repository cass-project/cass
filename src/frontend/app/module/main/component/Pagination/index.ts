import {Component, Input} from 'angular2/core';
import {CORE_DIRECTIVES} from 'angular2/common';

@Component({
    selector: 'pagination',
    styles: [
        require('./style.shadow.scss')
    ],
    template: require('./template.html'),
})
export class Pagination
{
    @Input() public pages:number;
    @Input() public linkPrefix:string = "page";
}