import {Component, Input} from "@angular/core";
import {UIPanelControl} from "../../../../../service/ui";

@Component({
    selector: 'cass-header-switcher',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class CASSHeaderSwitcher
{
    @Input('controls') controls: UIPanelControl;
}