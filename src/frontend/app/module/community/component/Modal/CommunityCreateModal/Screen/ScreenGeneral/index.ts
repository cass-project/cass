import {Component} from "angular2/core";

import {CommunityCreateModalModel} from "../../model";
import {Screen} from "../../screen";
import {CommunityCreateModalForm} from "../../Form/index";

@Component({
    selector: 'cass-community-create-modal-screen-general',
    template: require('./template.jade'),
    directives:[CommunityCreateModalForm]
})
export class ScreenGeneral extends Screen
{
    constructor(protected model: CommunityCreateModalModel) {
        super();
    }
}