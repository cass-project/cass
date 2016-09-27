import {Component, Input} from "@angular/core";
import {UIPanelControl, UIPanelControlExtended} from "../../../../../service/ui";

@Component({
    selector: 'cass-header-switcher-extended',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CASSHeaderExtendedSwitcher
{
    @Input('title') title: string;
    @Input('controls') controls: UIPanelControlExtended;
}