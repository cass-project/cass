import {Component, Input} from "@angular/core";

import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";
import {ContentPlayerService} from "../../service/ContentPlayerService/service";

@Component({
    selector: 'cass-content-player-area',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss'),
    ]
})
export class ContentPlayerArea
{
    constructor(
        private service: ContentPlayerService
    ) {}

    is(resource: string): boolean {
        let playlist = this.service.playlist;

        if(playlist.isEmpty()) {
            return false;
        }else{
            return playlist.getCurrent().link.resource === resource;
        }
    }
}