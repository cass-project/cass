import {Component, EventEmitter, Output} from "@angular/core";

import {CommunityRESTService} from "../../../service/CommunityRESTService";

@Component({
    selector: 'cass-community-route-modal',
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityRouteModal
{
    constructor(private service: CommunityRESTService) {}

    @Output("close") close = new EventEmitter<CommunityRouteModal>();
    @Output("create") create = new EventEmitter<CommunityRouteModal>();
    @Output("join") join = new EventEmitter<CommunityRouteModal>();
    @Output("destroy") destroy = new EventEmitter<CommunityRouteModal>();

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