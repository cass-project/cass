import {Component} from "@angular/core";
import {ChangeBackdropModel} from "../../model";

@Component({
    selector: 'cass-change-backdrop-cmp-image-settings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ImageSettings
{
    constructor(
        private model: ChangeBackdropModel
    ) {}
}