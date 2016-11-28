import {Component, EventEmitter, Output} from "@angular/core";
import { ChangeBackdropModel } from "../../model";

@Component({
    selector: 'cass-change-backdrop-cmp-palette-browser',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class PaletteBrowser
{}