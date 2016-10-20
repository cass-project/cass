import {Component} from "@angular/core";
import {UIPathService} from "../service";

@Component({
    selector: 'cass-ui-path',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class UIPathComponent
{
    constructor(
        private path: UIPathService,
    ) {}
}