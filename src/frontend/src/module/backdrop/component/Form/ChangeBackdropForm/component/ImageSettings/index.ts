import {Component} from "@angular/core";
import {ChangeBackdropModel} from "../../model";
import {Backdrop} from "../../../../../definitions/Backdrop";

@Component({
    selector: 'cass-change-backdrop-cmp-image-settings',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ImageSettings
{
    private backdrop: Backdrop<any>;

    constructor(
        private model: ChangeBackdropModel
    ) {
        this.backdrop = model.backdrop;
    }

    getBackdrop() {
        return this.model.backdrop;
    }
}