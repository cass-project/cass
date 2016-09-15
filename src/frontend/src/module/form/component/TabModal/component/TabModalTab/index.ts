import {Component, Input} from "@angular/core";

@Component({
    template: require('./template.jade')
,selector: 'cass-tab-modal-tab'})

export class TabModalTab
{
    public active: boolean = false;

    @Input("title") public title: string = 'TAB';
    @Input("position") public position: string = "top";
    @Input("force-active") public forceActive: string;
}