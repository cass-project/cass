import {Component, Directive} from "@angular/core";

import {CommunityService} from "../../service/CommunityService";
import {CommunityModalService} from "../../service/CommunityModalService";

@Component({
    template: require('./template.jade'),
    styles: [
        require('./style.shadow.scss')
    ]
})
@Directive({selector: 'cass-community-menu'})
export class CommunityMenuComponent
{
    constructor(private service: CommunityService, private modalsService: CommunityModalService){}
}