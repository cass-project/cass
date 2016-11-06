import {Component} from "@angular/core";

import {PostPlayerService} from "./service";

@Component({
    selector: 'cass-post-player',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class PostPlayer
{
    constructor(
        private service: PostPlayerService
    ) {}
}
