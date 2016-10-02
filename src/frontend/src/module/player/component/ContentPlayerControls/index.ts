import {Component} from "@angular/core";

import {ContentPlayerService} from "../../service/ContentPlayerService/service";

@Component({
    selector: 'cass-content-player-controls',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class ControlPlayerControls
{
    constructor(
        private service: ContentPlayerService
    ) {}

    prev() {
        this.service.controls.prev();
    }

    next() {
        this.service.controls.next();
    }

    shuffle() {
        this.service.controls.shuffle();
    }

    empty() {
        this.service.controls.empty();
    }

    hide() {
        this.service.controls.hide();
    }
}