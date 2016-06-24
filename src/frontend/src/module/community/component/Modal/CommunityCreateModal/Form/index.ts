import {Component} from "angular2/core";
import {Screen} from "../screen";

@Component({
    selector: 'cass-community-create-modal-form',
    template: require('./template.jade')
})

export class CommunityCreateModalForm extends Screen {}