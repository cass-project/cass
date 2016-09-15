import {Component, EventEmitter, Output} from "@angular/core";
import {CommunityRESTService} from "../../../service/CommunityRESTService";

@Component({
    template: require('./template.html'),
    styles: [
        require('./style.shadow.scss')
    ],selector: 'cass-community-route-modal'})
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