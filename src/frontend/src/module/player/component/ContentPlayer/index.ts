import {Component} from "@angular/core";
import {ContentPlayerService} from "../../service/ContentPlayerService/service";

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
}