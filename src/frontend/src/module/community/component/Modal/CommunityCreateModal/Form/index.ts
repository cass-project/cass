import {Component, Directive} from "@angular/core";
import {Screen} from "../screen";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-community-create-modal-form'})
export class CommunityCreateModalForm extends Screen {}