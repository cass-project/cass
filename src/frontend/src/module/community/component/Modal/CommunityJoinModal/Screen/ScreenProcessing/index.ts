import {Component} from "@angular/core";
import {Screen} from "../../screen";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-join-modal-screen-processing'})
export class ScreenProcessing extends Screen
{}