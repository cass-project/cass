import {Component} from "@angular/core";
import {Screen} from "../Screen/screen";

@Component({
    selector: 'cass-community-create-modal-form',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})

export class CommunityCreateModalForm extends Screen {}