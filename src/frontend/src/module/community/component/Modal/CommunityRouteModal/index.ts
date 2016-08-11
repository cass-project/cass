import {Component, EventEmitter, Output} from "@angular/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";
import {ModalComponent} from "../../../../modal/component/index";
import {ModalBoxComponent} from "../../../../modal/component/box/index";

@Component({
    selector: 'cass-community-route-modal',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ],
    directives: [
        ModalComponent,
        ModalBoxComponent,
    ]
})
export class CommunityRouteModal
{
    @Output("close") close = new EventEmitter<CommunityRouteModal>();
    @Output("create") create = new EventEmitter<CommunityRouteModal>();
    @Output("join") join = new EventEmitter<CommunityRouteModal>();
    @Output("destroy") destroy = new EventEmitter<CommunityRouteModal>();

    constructor(private service: CommunityRESTService) {}

    closeModal() {
        this.close.emit(this);
    }

    goCreate() {
        this.create.emit(this);
    }

    goJoin() {
        this.join.emit(this);
    }
}