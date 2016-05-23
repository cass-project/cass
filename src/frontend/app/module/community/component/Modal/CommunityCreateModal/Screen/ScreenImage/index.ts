import {Component} from "angular2/core";

import {Screen} from "../../screen";

@Component({
    selector: 'cass-community-create-modal-screen-image',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenImage extends Screen
{}