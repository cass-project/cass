import {Component} from "@angular/core";

import {CommunityService} from "../../service/CommunityService";
import {CommunityModalService} from "../../service/CommunityModalService";

@Component({
    selector: 'cass-community-menu',
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
export class CommunityMenuComponent
{
    constructor(private service: CommunityService, private modalsService: CommunityModalService){}
}