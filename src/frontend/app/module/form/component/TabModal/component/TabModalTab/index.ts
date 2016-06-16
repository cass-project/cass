import {Component, Input} from "angular2/core";
import {TabModal} from "../../index";

@Component({
    selector: 'cass-tab-modal-tab',
    template: require('./template.jade')
})
export class TabModalTab
{
    public active: boolean = false;
    
    @Input("title") public title: string = 'TAB';
    @Input("position") public position: string = "top";
}