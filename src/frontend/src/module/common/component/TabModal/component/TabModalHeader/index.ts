import {Component, Input} from "@angular/core";

@Component({
    selector: 'cass-tab-modal-header',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ] 
})

export class TabModalHeader
{
    @Input("level") level: string = "1";
}