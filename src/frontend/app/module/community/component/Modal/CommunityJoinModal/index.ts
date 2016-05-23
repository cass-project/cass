import {Component, EventEmitter, Output} from "angular2/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";
import {CommunityCreateModalModel} from "../CommunityCreateModal/model";

@Component({
    selector: 'cass-community-join-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent
    ],
    providers: [
        CommunityCreateModalModel
    ]
})
export class CommunityJoinModal
{
    @Output("close") close = new EventEmitter<CommunityJoinModal>();

    constructor(private service: CommunityRESTService, public model: CommunityCreateModalModel) {}

    close() {
        this.close.emit(this);
    }
}