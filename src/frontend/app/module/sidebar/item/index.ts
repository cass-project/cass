import {Component} from "angular2/core";
import {Input} from "angular2/core";

@Component({
    selector: 'cass-sidebar-item',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class SidebarItemComponent
{
}