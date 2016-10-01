import {Component} from "@angular/core";

import {ContentPlayerService} from "../../service/ContentPlayerService/service";
import {AttachmentEntity} from "../../../attachment/definitions/entity/AttachmentEntity";

@Component({
    selector: 'cass-content-player',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ContentPlayer
{
    constructor(
        private service: ContentPlayerService
    ) {}

    play(attachment: AttachmentEntity<any>) {
        this.service.controls.play(attachment);
    }
}