import {Component} from "@angular/core";

import {Screen} from "../../screen";

@Component({
    selector: 'cass-community-join-modal-screen-sid',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenSID extends Screen {}