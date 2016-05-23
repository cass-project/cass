import {Component} from "angular2/core";

import {Screen} from "../../screen";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenGeneral extends Screen
{
    title: string = '';
    description: string = '';
}