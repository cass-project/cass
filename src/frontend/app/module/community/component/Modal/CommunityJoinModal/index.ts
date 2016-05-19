import {Component, EventEmitter, Output} from "angular2/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";

@Component({
    selector: 'cass-community-join-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent
    ]
})
export class CommunityJoinModal
{
    @Output("close") close = new EventEmitter<CommunityJoinModal>();

    constructor(private service: CommunityRESTService) {}

    close() {
        this.close.emit(this);
    }
}