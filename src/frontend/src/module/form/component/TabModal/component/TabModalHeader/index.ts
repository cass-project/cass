import {Component, Input, Directive} from "@angular/core";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ] 
,selector: 'cass-tab-modal-header'})

export class TabModalHeader
{
    @Input("level") level: string = "1";
}