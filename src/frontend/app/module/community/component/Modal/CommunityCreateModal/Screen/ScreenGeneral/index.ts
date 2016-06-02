import {Component} from "angular2/core";

import {Screen} from "../../screen";
import {CommunityCreateModalModel} from "../../model";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ScreenGeneral extends Screen
{
    constructor(protected model: CommunityCreateModalModel) {
        super(model);
    }
}